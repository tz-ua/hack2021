<?php

namespace App\Http\Controllers;

use App\Models\Step;
use App\Models\Tutorial;
use Illuminate\Http\Request;

class StepsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/tutorials/{tutorialId}/steps",
     *     tags={"Step"},
     *     operationId="api.steps.index",
     *     summary="Returns list of availble steps for a tutorial",
     *     description="Returns list of availble steps for a tutorial",
     *     @OA\Parameter(
     *          name="tutorialId",
     *          description="Id of Tutorial",
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
    public function index(Tutorial $tutorial)
    {
        return $tutorial->steps->loadMissing(['tutorial.project']);
    }

    /**
     * @OA\Post(
     *     path="/api/tutorials/{tutorialId}/steps",
     *     tags={"Step"},
     *     operationId="api.steps.store",
     *     summary="Store new Step for a Tutorial",
     *     description="Store new Step for a Tutorial",
     *     @OA\Parameter(
     *          name="tutorialId",
     *          description="Id of Tutorial",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Step payload",
     *         @OA\JsonContent(
     *          @OA\Property(
     *              property="title",
     *              description="Step title",
     *              type="string",
     *              example="My New Step",
     *              minLength=1,
     *              maxLength=255
     *          ),
     *          @OA\Property(
     *              property="order",
     *              description="Step order",
     *              type="integer",
     *              example="1",
     *          ),
     *          @OA\Property(
     *              property="content",
     *              description="Step content",
     *              type="array",
     *              example={{"type": "heading-one","children": {{"text": "Article title"}}},},
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
    public function store(Request $request, Tutorial $tutorial)
    {
        return Step::firstOrCreate([
            'title' => $request->title,
            'order' => $request->order,
            'content' => $request->input('content'),
            'tutorial_id' => $tutorial->id
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/tutorials/{tutorialId}/steps-many",
     *     tags={"Step"},
     *     operationId="api.steps.store.many",
     *     summary="Store many Steps for a Tutorial",
     *     description="Store many Steps for a Tutorial",
     *     @OA\Parameter(
     *          name="tutorialId",
     *          description="Id of Tutorial",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Step payload",
     *         @OA\JsonContent(
     *          type="array",
     *          example={{"title": "Step 1", "order": 1, "content": {"type": "heading-one","children": {{"text": "Article title"}}},}},
     *          @OA\Items(
     *          @OA\Property(
     *              property="title",
     *              description="Step title",
     *              type="string",
     *              example="My New Step",
     *              minLength=1,
     *              maxLength=255
     *          ),
     *          @OA\Property(
     *              property="order",
     *              description="Step order",
     *              type="integer",
     *              example="1",
     *          ),
     *          @OA\Property(
     *              property="content",
     *              description="Step content",
     *              type="array",
     *              example={{"type": "heading-one","children": {{"text": "Article title"}}},},
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
    public function stepsMany(Request $request, Tutorial $tutorial)
    {
        $tutorial->steps()->delete();

        $steps = [];

        $stepsData = $request->input();
        if (!empty($stepsData)) {
            foreach ($stepsData as $stepData) {
                $steps[] = Step::create([
                    'title' => $stepData['title'] ?? null,
                    'order' => $stepData['order'] ?? null,
                    'content' => $stepData['content'] ?? null,
                    'tutorial_id' => $tutorial->id
                ]);
            }
        }

        return $steps;
    }

    /**
     * @OA\Get(
     *      path="/api/steps/{id}",
     *      operationId="api.steps.show",
     *      tags={"Step"},
     *      summary="Get Step",
     *      description="Get specific Step",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id of Step",
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
    public function show(Step $step)
    {
        return $step->loadMissing(['tutorial.project']);
    }

    /**
     * @OA\Patch(
     *     path="/api/steps/{id}",
     *     tags={"Step"},
     *     operationId="api.steps.update",
     *     summary="Update Step",
     *     description="Update existing Step",
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         description="Updated Step identifier",
     *         example=1,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Step payload",
     *         @OA\JsonContent(
     *          @OA\Property(
     *              property="title",
     *              description="Step title",
     *              type="string",
     *              example="My New Step",
     *              minLength=1,
     *              maxLength=255
     *          ),
     *          @OA\Property(
     *              property="order",
     *              description="Step order",
     *              type="integer",
     *              example="1",
     *          ),
     *          @OA\Property(
     *              property="content",
     *              description="Step content",
     *              type="string",
     *              example={{"type": "heading-one","children": {{"text": "Article title"}}},},
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
    public function update(Request $request, Step $step)
    {
        if (!empty($request->title)) {
            $step->title = $request->title;
        }

        if (!empty($request->order)) {
            $step->order = $request->order;
        }

        $content = $request->input('content');
        if (!empty($content)) {
            $step->content = $content;
        }

        $step->save();

        return $step;
    }

    /**
     * @OA\Delete(
     *     path="/api/steps/{id}",
     *     tags={"Step"},
     *     operationId="api.steps.destroy",
     *     summary="Delete Step by identifier",
     *     description="Delete Step by identifier",
     *      @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         description="Step identifier",
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
    public function destroy(Step $step)
    {
        return $step->delete();
    }
}
