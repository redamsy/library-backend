<?php

namespace App\Http\Controllers;

use App\BookClient;
use App\Book;
use App\Client;
use App\Admin;
use App\Http\Resources\BookClientResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BookClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bookclients = BookClient::all();
        return BookClientResource::collection($bookclients);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        if( $client = Client::where('id', Auth::guard('api')->user()->id )->exists()){
            $book = Book::findOrFail($request->input('book_id'));

            if(!(BookClient::where('book_id', $request->input('book_id') )
                ->where('client_id', Auth::guard('api')->user()->id )->exists())
            ){

                $bookClientCreate = BookClient::create([
                    "book_id" => $request->book_id,
                    "client_id" => Auth::guard('api')->user()->id,
                ]);
                if($bookClientCreate){
                    $headers = [
                        'Content-Type' => 'application/pdf',
                    ];
                    
                    return response()->download(public_path('pdfs\books\\'.$book->pdfName), $book->title, $headers);
                }
            }
            $headers = [
                'Content-Type' => 'application/pdf',
            ];
            
            return response()->download(public_path('pdfs\books\\'.$book->pdfName), $book->title, $headers);
        }
        if( $admin = Admin::where('id', Auth::guard('api')->user()->id )->exists()){
            $book = Book::findOrFail($request->input('book_id'));
            $headers = [
                'Content-Type' => 'application/pdf',
            ];
            
            return response()->download(public_path('pdfs\books\\'.$book->pdfName), $book->title, $headers);
        }
        return response()->json(["message" => "You are not an client"], 401);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
