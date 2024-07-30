<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Traits\HandlesApiRequests;
use App\Models\BlogPost;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogPostController extends BaseController
{
    use HandlesApiRequests;
    public function index(Request $request)
    {
        $query = BlogPost::query();
        $results = $this->handleApiRequest($request, $query);

        // Convert $results to a collection if it's an array
        $results = collect($results);
        if ($results->isEmpty()) {
            return $this->sendErrorResponse('No records found', 404);
        }

        return $this->sendSuccessResponse('Records retrieved successfully', $results);
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $post = new BlogPost;
            $post->title = $validatedData['title'];
            $post->content = $validatedData['content'];
            $post->seo_title = $validatedData['title'];
            $post->meta_description = Str::limit(strip_tags($validatedData['content']), 160);
            //$post->meta_keywords = $this->generateMetaKeywords($validatedData['content']);
            $post->og_title = $validatedData['title'];
            $post->og_description = Str::limit(strip_tags($validatedData['content']), 160);
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
                $post->thumbnail = $thumbnailPath;
                $post->og_image = $thumbnailPath;
            }
            $post->slug = Str::slug($validatedData['title'], '-');
            $post->canonical_url = Str::slug($validatedData['title'], '-');
            $post->save();
    
            return $this->sendSuccessResponse('Record created successfully', $post);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    private function generateMetaKeywords($content)
    {
        // Extracting words from content and converting to comma-separated keywords
        $words = explode(' ', strip_tags($content));
        $keywords = implode(', ', array_slice($words, 0, 10)); // Limiting to 10 keywords

        return $keywords;
    }

    
    public function show($slug)
    {
        try {
            $post = BlogPost::where('slug', $slug)->firstOrFail();
            return $this->sendSuccessResponse('Records retrieved successfully', $post);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = BlogPost::findOrFail($id);
        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        try {
            if ($request->has('title')) {
                $post->seo_title = $validatedData['title'];
                $post->og_title = $validatedData['title'];
                $post->slug = Str::slug($validatedData['title'], '-');
                $post->canonical_url = Str::slug($validatedData['title'], '-');
            }
    
            if ($request->has('content')) {
                $post->meta_description = Str::limit(strip_tags($validatedData['content']), 160);
                $post->meta_keywords = $this->generateMetaKeywords($validatedData['content']);
                $post->og_description = Str::limit(strip_tags($validatedData['content']), 160);
            }
    
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
                $post->thumbnail = $thumbnailPath;
                $post->og_image = $thumbnailPath;
            }
            $post->save();

            return $this->sendSuccessResponse('Record updated successfully', $post);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     //
    // }
}
