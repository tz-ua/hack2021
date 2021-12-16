<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Project;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/projects/{projectId}/articles",
     *     tags={"Article"},
     *     operationId="api.articles.index",
     *     summary="Returns list of availble articles for a project",
     *     description="Returns list of availble articles for a project",
     *     @OA\Parameter(
     *          name="projectId",
     *          description="Id of Project",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfull operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/ApiResponse")
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(ref="#/components/schemas/ApiResponse"),
     *      ),
     * )
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        return $project->articles->loadMissing(['project']);
    }

    /**
     * @OA\Post(
     *     path="/api/projects/{projectId}/articles",
     *     tags={"Article"},
     *     operationId="api.articles.store",
     *     summary="Store new Article for a project",
     *     description="Store new Article for a project",
     *     @OA\Parameter(
     *          name="projectId",
     *          description="Id of Project",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Article payload",
     *         @OA\JsonContent(
     *          @OA\Property(
     *              property="title",
     *              description="Article title",
     *              type="string",
     *              example="My New Article",
     *              minLength=1,
     *              maxLength=255
     *          ),
     *          @OA\Property(
     *              property="content",
     *              description="Article content",
     *              type="array",
     *              example={{"type": "heading-one","children": {{"text": "Article title"}}},{"type": "paragraph","children": {{"text": "This is editable","bold": true,"italic": true}}},{"type": "bulleted-list","children": {{"type": "list-item","children":{{"text": "test"}}}}}},
     *              @OA\Items(
     *                  @OA\Property(
     *                      property="type",
     *                      type="string",
     *                      example="heading-one"
     *                  ),
     *                  @OA\Property(
     *                      property="children",
     *                      type="array",
     *                      example="heading-one",
     *                      @OA\Items(
     *                          @OA\Property(
     *                              property="text",
     *                              type="string",
     *                              example="Article title"
     *                          ),
     *                      )
     *                  ),
     *              )
     *          )
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfull operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                property="data",
     *                type="object",
     *                ref="#/components/schemas/ApiResponse"
     *             )
     *        )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(ref="#/components/schemas/ApiResponse"),
     *      ),
     * )
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project)
    {
        return Article::firstOrCreate([
            'title' => $request->title,
            'content' => $request->input('content'),
            'project_id' => $project->id
        ]);
    }

    /**
     * @OA\Get(
     *      path="/api/articles/{id}",
     *      operationId="api.articles.show",
     *      tags={"Article"},
     *      summary="Get Article",
     *      description="Get specific Article",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id of Article",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *             @OA\Property(
     *                property="data",
     *                type="object",
     *                ref="#/components/schemas/ApiResponse"
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(ref="#/components/schemas/ApiResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiResponse"),
     *      ),
     * )
     *
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return $article->loadMissing(['project']);
    }

    /**
     * @OA\Patch(
     *     path="/api/articles/{id}",
     *     tags={"Article"},
     *     operationId="api.articles.update",
     *     summary="Update Article",
     *     description="Update existing Article",
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         description="Updated Article identifier",
     *         example=1,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Article payload",
     *         @OA\JsonContent(
     *          @OA\Property(
     *              property="title",
     *              description="Article title",
     *              type="string",
     *              example="My New Article",
     *              minLength=1,
     *              maxLength=255
     *          ),
     *          @OA\Property(
     *              property="content",
     *              description="Article content",
     *              type="string",
     *              example={{"type": "heading-one","children": {{"text": "Article title"}}},{"type": "paragraph","children": {{"text": "This is editable","bold": true,"italic": true}}},{"type": "bulleted-list","children": {{"type": "list-item","children":{{"text": "test"}}}}}},
     *          ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfull operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                property="data",
     *                type="object",
     *                ref="#/components/schemas/ApiResponse"
     *             )
     *        )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(ref="#/components/schemas/ApiResponse"),
     *      ),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        if (!empty($request->title)) {
            $article->title = $request->title;
        }

        $content = $request->input('content');
        if (!empty($content)) {
            $article->content = $content;
        }

        $article->save();

        return $article;
    }

    /**
     * @OA\Delete(
     *     path="/api/articles/{id}",
     *     tags={"Article"},
     *     operationId="api.articles.destroy",
     *     summary="Delete Article by identifier",
     *     description="Delete Article by identifier",
     *      @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         description="Article identifier",
     *         example=1,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *      ),
     *     @OA\Response(
     *         response=204,
     *         description="Successfull operation",
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="Resource Not Found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiResponse"),
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(ref="#/components/schemas/ApiResponse"),
     *      ),
     * )
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        return $article->delete();
    }
}
