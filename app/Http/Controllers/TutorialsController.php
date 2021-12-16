<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Tutorial;
use Illuminate\Http\Request;

class TutorialsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/projects/{projectId}/tutorials",
     *     tags={"Tutorial"},
     *     operationId="api.tutorials.index",
     *     summary="Returns list of availble tutorials for a project",
     *     description="Returns list of availble tutorials for a project",
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
        return $project->tutorials->loadMissing(['project', 'steps']);
    }

    /**
     * @OA\Post(
     *     path="/api/projects/{projectId}/tutorials",
     *     tags={"Tutorial"},
     *     operationId="api.tutorials.store",
     *     summary="Store new Tutorial",
     *     description="Store new Tutorial",
     *     @OA\Parameter(
     *          name="projectId",
     *          description="Id of Project",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *      ),
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
     *         description="Tutorial payload",
     *         @OA\JsonContent(
     *          @OA\Property(
     *              property="name",
     *              description="Tutorial name",
     *              type="string",
     *              example="My Tutorial Name",
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
    public function store(Request $request, Project $project)
    {
        return Tutorial::firstOrCreate([
            'name' => $request->name,
            'project_id' => $project->id
        ]);
    }

    /**
     * @OA\Get(
     *      path="/api/tutorials/{id}",
     *      operationId="api.tutorials.show",
     *      tags={"Tutorial"},
     *      summary="Get Tutorial",
     *      description="Get specific Tutorial",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id of Tutorial",
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
    public function show(Tutorial $tutorial)
    {
        return $tutorial->loadMissing(['project', 'steps']);
    }

    /**
     * @OA\Put(
     *     path="/api/tutorials/{id}",
     *     tags={"Tutorial"},
     *     operationId="api.tutorials.update",
     *     summary="Update Tutorial",
     *     description="Update existing Tutorial",
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         description="Updated Tutorial identifier",
     *         example=1,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Tutorial payload",
     *         @OA\JsonContent(
     *          @OA\Property(
     *              property="name",
     *              description="Tutorial name",
     *              type="string",
     *              example="My Tutorial Name",
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
    public function update(Request $request, Tutorial $tutorial)
    {
        $tutorial->name = $request->name;

        $tutorial->save();

        return $tutorial;
    }

    /**
     * @OA\Delete(
     *     path="/api/tutorials/{id}",
     *     tags={"Tutorial"},
     *     operationId="api.tutorials.destroy",
     *     summary="Delete Tutorial by identifier",
     *     description="Delete Tutorial by identifier",
     *      @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         description="Tutorial identifier",
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
    public function destroy(Tutorial $tutorial)
    {
        return $tutorial->delete();
    }
}
