<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Interfaces\PostInterface;
use App\Services\PdfService;
use App\Repositories\PostRepository;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="ConectApps Rest API",
 *      description="ConectApps Rest API",
 *
 *      @OA\Contact(
 *          email="loisagaston@gmail.com"
 *      ),
 *      @OA\License(
 *         name="Apache 2.0",
 *         url="https://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */
class PostController extends Controller
{
    protected $postInterface;
    protected $pdfService;
    /**
     * Create a new constructor for this controller
     */
    public function __construct(PostInterface $postInterface)
    {
     //   $this->middleware('auth:api');
        $this->postInterface = $postInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->postInterface->getAllPost();
    }

    /**
         * Display a listing of the resource.
         * Mostramos el listado de los regitros solicitados.
         * @return \Illuminate\Http\Response
         *
         * @OA\Get(
         *     path="/api/posts/pdf",
         *     tags={"posts"},
         *     summary="Muestra toda la información almacenada en base de datos y la retorna en forma de tabla en un archivo PDF.",
         *     @OA\Response(
         *         response=200,
         *         description="Muestra toda la información almacenada en base de datos y la retorna en forma de tabla en un archivo PDF."
         *     ),
         *     @OA\Response(
         *         response="default",
         *         description="Ha ocurrido un error."
         *     )
         * )
         */
    public function generatePdf(PdfService $pdfService){
        $postRepository = new PostRepository();
        $posts = $postRepository->generatePdfAllPost();
        $primero = $posts->first();
        $table_columns = array_keys(json_decode($primero, true));
        return $pdfService->createPdf($posts,$table_columns);
    }

    /**
     * @OA\Post(
     *      path="/api/post",
     *      operationId="storePost",
     *      tags={"posts"},
     *      summary="Crea un nuevo post",
     *      description="Retorna data de post",
     *      @OA\RequestBody(
     *          required=true
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function store(PostRequest $request)
    {
        return $this->postInterface->store($request);
    }

    /**
     * Display the specified resource.
     * Muestra el registro solicitado
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/posts/{post}",
     *     tags={"posts"},
     *     summary="Muestra información almacenada en base de datos filtrando por id y en formato json.",
     *     @OA\Parameter(
     *         description="Parámetro necesario para la consulta de datos de un post",
     *         in="path",
     *         name="post",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="int", value="1", summary="Introduce un número de id de post.")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar info de un post."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se ha encontrado el post."
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *     )
     * )
     */
    public function show($id)
    {
        return $this->postInterface->getPostById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        return $this->postInterface->update($request, $id);
    }


    /**
     * @OA\Delete(
     *      path="/api/posts/{post}",
     *      tags={"posts"},
     *      summary="Elimina post",
     *      description="Elimina post",
     *      @OA\Parameter(
     *          name="id",
     *          description="Post id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function destroy($id)
    {
        return $this->postInterface->deletePost($id);
    }


     /**
     * @OA\Delete(
     *      path="/api/posts/{post}",
     *      tags={"posts"},
     *      summary="Elimina post",
     *      description="Elimina post",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function destroyAllPost()
    {
        return $this->postInterface->deleteAllPost();
    }
}
