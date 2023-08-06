<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Validator;
use App\Http\Resources\StoryResource;
use Illuminate\Http\JsonResponse;

use App\Models\Story;

class StoryController extends BaseController
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $user = auth()->user();
        if ($user->isAdmin()) {
            $stories = Story::orderBy('status','desc')->get();

            return $this->sendResponse(StoryResource::collection($stories), 'Stories retrieved successfully.');
        } else {
            $stories = Story::whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->orWhere('status', 'Published')->orderBy('status','desc')->get();

            return $this->sendResponse(StoryResource::collection($stories), 'Stories retrieved successfully.');
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $input = $request->all();
        $users = $input['users_id'];

        $validator = Validator::make($input, [
            'title' => 'required',
            'content' => 'required',
            'status' => 'required',
            'users_id' => 'required',
            'created_by' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $story = new Story;
        $story->title = $input['title'];
        $story->content = $input['content'];
        $story->status = $input['status'];
        $story->created_by = $input['created_by'];
        $story->save();
        $story->users()->attach($users);
   
        return $this->sendResponse(new StoryResource($story), 'Story created successfully.');
    } 

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $story = Story::find($id);
  
        if (is_null($story)) {
            return $this->sendError('Story not found.');
        }
   
        return $this->sendResponse(new StoryResource($story), 'Story retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): JsonResponse
    {
        $input = $request->all();
        $users = $input['users_id'];
   
        $validator = Validator::make($input, [
            'title' => 'required',
            'content' => 'required',
            'status' => 'required',
            'users_id' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $story = Story::find($id);
        $story->title = $input['title'];
        $story->content = $input['content'];
        $story->status = $input['status'];
        $story->published_by = $input['published_by'];
        $story->save();
        $story->users()->sync($users);
   
        return $this->sendResponse(new StoryResource($story), 'Story updated successfully.');
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): JsonResponse
    {
        $story = Story::find($id);
        $story->users()->detach();
        $story->delete();
   
        return $this->sendResponse([], 'Story deleted successfully.');
    }
}
