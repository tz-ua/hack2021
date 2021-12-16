<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/projects",
     *     tags={"Project"},
     *     operationId="api.projects.index",
     *     summary="Returns list of availble projects",
     *     description="Returns list of availble projects",
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
    public function index()
    {
        return Project::with(['tutorials.steps', 'articles'])->get();
    }

    /**
     * @OA\Post(
     *     path="/api/projects",
     *     tags={"Project"},
     *     operationId="api.projects.store",
     *     summary="Store new Project",
     *     description="Store new Project",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Project payload",
     *         @OA\JsonContent(
     *          @OA\Property(
     *              property="name",
     *              description="Project name",
     *              type="string",
     *              example="My Project Name",
     *              minLength=1,
     *              maxLength=255
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
    public function store(Request $request)
    {
        return Project::firstOrCreate($request->only(['name']));
    }

    /**
     * @OA\Get(
     *      path="/api/projects/{id}",
     *      operationId="api.projects.show",
     *      tags={"Project"},
     *      summary="Get Project",
     *      description="Get specific Project",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id of Project",
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
    public function show($id)
    {
        return Project::findOrFail($id)->loadMissing(['tutorials.steps', 'articles']);
    }

    /**
     * @OA\Put(
     *     path="/api/projects/{id}",
     *     tags={"Project"},
     *     operationId="api.projects.update",
     *     summary="Update Project",
     *     description="Update existing Project",
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         description="Updated project identifier",
     *         example=1,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Project payload",
     *         @OA\JsonContent(
     *          @OA\Property(
     *              property="name",
     *              description="Project name",
     *              type="string",
     *              example="My Project Name",
     *              minLength=1,
     *              maxLength=255
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $project->name = $request->name;

        $project->save();

        return $project;
    }

    /**
     * @OA\Delete(
     *     path="/api/projects/{id}",
     *     tags={"Project"},
     *     operationId="api.projects.destroy",
     *     summary="Delete Project by identifier",
     *     description="Delete Project by identifier",
     *      @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         description="Project identifier",
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
    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        return $project->delete();
    }
}
