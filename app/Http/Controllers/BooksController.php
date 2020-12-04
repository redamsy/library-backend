<?php

namespace App\Http\Controllers;

use App\Book;
use App\BookCategory;
use App\BookAuthor;
use App\Publisher;
use App\Serie;
use App\Language;
use App\Http\Resources\BookResource;
use App\Admin;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\carbon;
use DateTime;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    /**
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $books = Book::all();
        return BookResource::collection($books);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if( $admin = Admin::where('id', Auth::guard('api')->user()->id )->exists()){
            if(!(Book::where('publisher_id', $request->input('publisher_id') )
                ->where('serie_id', $request->input('serie_id') )
                ->where('language_id', $request->input('language_id') )
                ->where('title', $request->input('title') )
                ->where('publishDate', $request->input('publishDate') )->exists())
            ){
                //return response()->json(["message" => is_array($request->image)], 201);
                $validator = Validator::make($request->all(), [
                    'publisher_id' => 'required|integer',
                    'serie_id' => 'required|integer',
                    'language_id' => 'required|integer',
                    'title' => 'required|max:255|string',
                    'description' => 'required||string',
                    'publishDate' => 'required|date_format:"Y-m-d"',
                    'price' => 'required|regex:/^\d*(\.\d{1,2})?$/',
                    'chapters' => 'required|integer',
                    'pages' => 'required|integer',

                ]);

                $publishDate = explode("-", $request->publishDate);

                if( Publisher::where('id', $request->input('publisher_id') )->exists() &&
                    Serie::where('id', $request->input('serie_id') )->exists() &&
                    Language::where('id', $request->input('language_id') )->exists())
                {
                    if($request->hasFile('image') && $request->hasFile('pdf'))
                    {   $request->validate([
                        'image' => 'required',
                        'image.*' => 'image|max:2048|mimes:jpeg,png,jpg',
                        'pdf' => 'required',
                        'pdf.*' => 'pdf|max:2048|mimes:pdf'//TODO: make sure
                        ]);
                        $image = $request->image;
                        $pdf = $request->pdf;
                        $imageName = ''; 
                        $pdfName = ''; 
                        if ($image->isValid() && $pdf->isValid()) {
                            do{  
                                $extension = $image->getClientOriginalExtension(); // getting image extension
                                $imageName = rand(1,99999999).'.'.$extension; // renaming image//or use time().
                            }while(file_exists("images/" . $imageName));

                            do{  
                                $extension = $pdf->getClientOriginalExtension(); // getting pdf extension
                                $pdfName = rand(1,99999999).'.'.$extension; // renaming pdf//or use time().
                            }while(file_exists("pdfs/" . $pdfName));
            
                            $image->move(public_path('images/books'), $imageName); // uploading image to given path
                            $pdf->move(public_path('pdfs/books'), $pdfName); // uploading pdf to given path
                        }
                        if($imageName && $pdfName) {
                            $bookCreate = Book::create([
                                "publisher_id" => $request->publisher_id,
                                "serie_id" => $request->serie_id,
                                "language_id" => $request->language_id,
                                "title" => $request->title,
                                "description" => $request->description,
                                "publishDate" => Carbon::create($publishDate[0], $publishDate[1], $publishDate[2]),
                                "price" => $request->price,
                                "chapters" => $request->chapters,
                                "pages" => $request->pages,
                                "isProhibited" => $request->isProhibited,
                                "imageName" => $imageName,
                                "pdfName" => $pdfName,
                            ]);
                            if($bookCreate) {   
                                return new BookResource($bookCreate);
                            }
                        }
                    }
                    return response()->json(["message" => "image and pdf input are needed"], 409);
                }
                return response()->json(["message" => "Publisher, serie, or language doesn't exist"], 409);
            }
            return response()->json(["message" => "Resource already exist"], 409);
        }
        return response()->json(["message" => "You are not an admin"], 401);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $book = Book::findOrFail($id);
        return new BookResource($book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if( $admin = Admin::where('id', Auth::guard('api')->user()->id )->exists()){
            $exists = Book::where('publisher_id', $request->input('publisher_id') )
                ->where('serie_id', $request->input('serie_id') )
                ->where('language_id', $request->input('language_id') )
                ->where('title', $request->input('title') )
                ->where('publishDate', $request->input('publishDate') )
                ->where('id','<>', $id )
                ->count();
            if($exists < 1){
                $book = Book::findOrFail($id);
                $this->updateCategories($request->category_ids, $id);
                $this->updateAuthors($request->author_ids, $id);
                //return response()->json(["message" => is_array($request->image)], 201);
                $validatedData = $request->validate([
                    'publisher_id' => 'required|integer',
                    'serie_id' => 'required|integer',
                    'language_id' => 'required|integer',
                    'title' => 'required|max:255|string',
                    'description' => 'required||string',
                    'publishDate' => 'required|date_format:"Y-m-d"',
                    'price' => 'required|regex:/^\d*(\.\d{1,2})?$/',
                    'chapters' => 'required|integer',
                    'pages' => 'required|integer',
                    'isProhibited' => 'required|boolean',
                    //'author.name' => 'required',

                ]);

                $publishDate = explode("-", $request->publishDate);

                if( Publisher::where('id', $request->input('publisher_id') )->exists() &&
                    Serie::where('id', $request->input('serie_id') )->exists() &&
                    Language::where('id', $request->input('language_id') )->exists())
                {
                    if($request->hasFile('image') && $request->hasFile('pdf'))
                    {   $request->validate([
                        'image' => 'required',
                        'image.*' => 'image|max:2048|mimes:jpeg,png,jpg',
                        'pdf' => 'required',
                        'pdf.*' => 'pdf|max:2048|mimes:pdf'
                        ]);
                        $image = $request->image;
                        $imageName = ''; 
                        $pdf = $request->pdf;
                        $pdfName = ''; 
                        if ($image->isValid() && $pdf->isValid()) {
                            do{  
                                $extension = $image->getClientOriginalExtension(); // getting image extension
                                $imageName = rand(1,99999999).'.'.$extension; // renaming image//or use time().
                            }while(file_exists("images/" . $imageName));
                            
                            do{  
                                $extension = $pdf->getClientOriginalExtension(); // getting pdf extension
                                $pdfName = rand(1,99999999).'.'.$extension; // renaming pdf//or use time().
                            }while(file_exists("pdfs/" . $pdfName));
            
                            $image->move(public_path('images/books'), $imageName); // uploading image to given path
                            $pdf->move(public_path('pdfs/books'), $pdfName); // uploading pdf to given path
                        }
                        if($imageName && $pdfName) {
                            $bookUpdate = Book::where('id', $book->id)
                                ->update([
                                    "publisher_id" => $request->publisher_id,
                                    "serie_id" => $request->serie_id,
                                    "language_id" => $request->language_id,
                                    "title" => $request->title,
                                    "description" => $request->description,
                                    "publishDate" => Carbon::create($publishDate[0], $publishDate[1], $publishDate[2]),
                                    "price" => $request->price,
                                    "chapters" => $request->chapters,
                                    "pages" => $request->pages,
                                    "isProhibited" => $request->isProhibited,
                                    "imageName" => $imageName,
                                    "pdfName" => $pdfName,
                                ]);
                            if($bookUpdate) {
                                return new BookResource(Book::findOrFail($id));
                            }
                        }
                    }
                    if($request->hasFile('image'))
                    {   $request->validate([
                        'image' => 'required',
                        'image.*' => 'image|max:2048|mimes:jpeg,png,jpg',
                        ]);
                        $image = $request->image;
                        $imageName = ''; 
                        if ($image->isValid()) {
                            do{  
                                $extension = $image->getClientOriginalExtension(); // getting image extension
                                $imageName = rand(1,99999999).'.'.$extension; // renaming image//or use time().
                            }while(file_exists("images/" . $imageName));
            
                            $image->move(public_path('images/books'), $imageName); // uploading image to given path
                        }
                        if($imageName) {
                            $bookUpdate = Book::where('id', $book->id)
                                ->update([
                                    "publisher_id" => $request->publisher_id,
                                    "serie_id" => $request->serie_id,
                                    "language_id" => $request->language_id,
                                    "title" => $request->title,
                                    "description" => $request->description,
                                    "publishDate" => Carbon::create($publishDate[0], $publishDate[1], $publishDate[2]),
                                    "price" => $request->price,
                                    "chapters" => $request->chapters,
                                    "pages" => $request->pages,
                                    "isProhibited" => $request->isProhibited,
                                    "imageName" => $imageName,
                                ]);
                            if($bookUpdate) {
                                return new BookResource(Book::findOrFail($id));
                            }
                        }
                    }
                    if($request->hasFile('pdf'))
                    {   $request->validate([
                        'pdf' => 'required',
                        'pdf.*' => 'pdf|max:2048|mimes:pdf'
                        ]);
                        $pdf = $request->pdf;
                        $pdfName = ''; 
                        if ($pdf->isValid()) {                            
                            do{  
                                $extension = $pdf->getClientOriginalExtension(); // getting pdf extension
                                $pdfName = rand(1,99999999).'.'.$extension; // renaming pdf//or use time().
                            }while(file_exists("pdfs/" . $pdfName));
            
                            $pdf->move(public_path('pdfs/books'), $pdfName); // uploading pdf to given path
                        }
                        if($pdfName) {
                            $bookUpdate = Book::where('id', $book->id)
                                ->update([
                                    "publisher_id" => $request->publisher_id,
                                    "serie_id" => $request->serie_id,
                                    "language_id" => $request->language_id,
                                    "title" => $request->title,
                                    "description" => $request->description,
                                    "publishDate" => Carbon::create($publishDate[0], $publishDate[1], $publishDate[2]),
                                    "price" => $request->price,
                                    "chapters" => $request->chapters,
                                    "pages" => $request->pages,
                                    "isProhibited" => $request->isProhibited,
                                    "pdfName" => $pdfName,
                                ]);
                            if($bookUpdate) {
                                return new BookResource(Book::findOrFail($id));
                            }
                        }
                    }
                    $bookUpdate = Book::where('id', $book->id)
                        ->update([
                            "publisher_id" => $request->publisher_id,
                            "serie_id" => $request->serie_id,
                            "language_id" => $request->language_id,
                            "title" => $request->title,
                            "description" => $request->description,
                            "publishDate" => Carbon::create($publishDate[0], $publishDate[1], $publishDate[2]),
                            "price" => $request->price,
                            "chapters" => $request->chapters,
                            "pages" => $request->pages,
                            "isProhibited" => $request->isProhibited,
                        ]);
                    if($bookUpdate) {
                        return new BookResource(Book::findOrFail($id));
                    }
                }
                return response()->json(["message" => "Publisher, serie, or language doesn't exist"], 409);
            }
            return response()->json(["message" => "Resource already exist"], 409);
        }
        return response()->json(["message" => "You are not an admin"], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if( $admin = Admin::where('id', Auth::guard('api')->user()->id )->exists()){
            $book = Book::findOrFail($id);
            
            if($book->delete()){
                return response()->json(["message" => "book deleted"], 201);
            }
        }
        return response()->json(["message" => "You are not an admin"], 401);
    }

    public function updateCategories($category_ids, $book_id) {
        BookCategory::where('book_id',$book_id)->delete();

        foreach ($category_ids as $category_id) {
            $bookCategoryCreate = BookCategory::create([
                "book_id" => $book_id,
                "category_id" => $category_id,
            ]);
        }
        
    }
    public function updateAuthors($author_ids, $book_id) {
        BookAuthor::where('book_id',$book_id)->delete();

        foreach ($author_ids as $author_id) {
            $bookAuthorCreate = BookAuthor::create([
                "book_id" => $book_id,
                "author_id" => $author_id,
            ]);
        }
        
    }
}
