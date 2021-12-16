<?php

/**
 * This file contains all common annotations for L5-Swagger
 *
 * To manually regenerate swagger yaml/json files use command:
 * php artisan l5-swagger:generate
 * or set .env variable L5_SWAGGER_GENERATE_ALWAYS to true to automatically generate swagger files
 *
 * Swagger url: /api/documentation
 *
 * @link https://github.com/DarkaOnLine/L5-Swagger
 * @link https://github.com/zircote/swagger-php/blob/master/docs/Getting-started.md
 */



/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Help Center",
 *      description="Documentation for Help Center - Hackaton 2021 (winter)",
 *      @OA\Contact(
 *          email="mail@example.com"
 *      ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */

/**
 * Tags
 *
 * @OA\Tag(
 *     name="Project",
 *     description="Projects supported by system",
 * )
 *
 * @OA\Tag(
 *     name="Tutorial",
 *     description="Tutorials available for a project",
 * )
 *
 * @OA\Tag(
 *     name="Step",
 *     description="Tutorial Step",
 * )
 *
 * @OA\Tag(
 *     name="Article",
 *     description="Project Article describing any specific feature",
 * )
 *
 */

/**
 * Common Schema Objects
 *
 * @OA\Schema(
 *      schema="ApiResponse",
 *      title="Api response",
 *      description="Common Api response",
 *      @OA\Property(
 *          property="fieldName",
 *          type="string",
 *          title="fieldName",
 *          description="fieldName",
 *          example="field value",
 *      )
 * )
 *
 */
