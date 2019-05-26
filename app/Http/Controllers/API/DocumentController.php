<?php

namespace App\Http\Controllers\API;

use App\Document;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreDocument ;
use App\Http\Controllers\Controller ;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $documents = Document::All();
        return response()->json($documents);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
   
        $document = Document::find($id);

        if(!$document){
            return response()->json(['errors'=> 'Not found'], 404);
        }

       return response()->json($document);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $document = new Document;
        $document->title = $request->title;
        $document->user_id = $request->user_id;

        if($document->save() == 1){
            return response()->json($document,201);
        }else{
             return response()->json(['errors'=>'Some error occurs'],400);
        }

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

         $validator = Validator::make($request->all(), [
            'title' => 'required|min:5'
        ]);

        
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }


        if(!$this->checkRights($id)){
           return response()->json(['errors'=> 'Not found'], 403);
        }

        $document = Document::find($id);
        $document->title = $request->title;
        if($document->save()){
            return response()->json($document, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if(!$this->checkRights($id)){
           return response()->json(['errors'=> 'Not found'], 404);
        }

        Document::find($id)->delete();

        return  response()->json(null, 204);

    }

   /**
     * The function checks the availability of the document.
     *
     * I think here is some more optimal solution for this task.
     *
     * @param  int  $postId
     * @return boolean
     */

    public function checkRights($postId){
        $document = Document::where(['user_id'=> Auth::id(),'id' => $postId])->get();

        return $document->count() == 0 ? false : true;
    }
}
