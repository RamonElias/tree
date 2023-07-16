<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NodeCollection;
use App\Http\Resources\NodeResource;
use App\Models\Node;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @OA\Info(
 *      version="0.0.1",
 *      title="OpenApi documentation for Tree Nodes",
 *      description="Swagger OpenApi documentation for Tree Nodes",
 *
 *      x={
 *          "logo": {
 *              "url": "https://via.placeholder.com/190x90.png?text=L5-Swagger"
 *          }
 *      },
 *
 *      @OA\Contact(
 *          email="info@website.com"
 *      ),
 *
 *      @OA\License(
 *         name="Apache 2.0",
 *         url="https://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */
class NodeController extends Controller
{
    /**
     * Display a listing of the resource.
     * Showing all nodes paginated.
     *
     * @return \Illuminate\Http\Response
     *
     * @OA\Get(
     *   path="/api/nodes",
     *   tags={"nodes"},
     *   summary="All nodes paginated",
     *
     *   @OA\Parameter(
     *     name="X-Header-Timezone",
     *     in="header",
     *     description="Get date fields in specific Timezone",
     *     required=false,
     *
     *     @OA\Examples(example="Caracas", value="America/Caracas", summary="Caracas"),
     *     @OA\Examples(example="Bogota", value="America/Bogota", summary="Bogota"),
     *     @OA\Examples(example="Los Angeles", value="America/Los_Angeles", summary="Los Angeles"),
     *   ),
     *
     *   @OA\Parameter(
     *     name="X-Header-Lang",
     *     in="header",
     *     description="Get title field in specific language",
     *     required=false,
     *
     *     @OA\Examples(example="en", value="en", summary="English"),
     *     @OA\Examples(example="es", value="es", summary="Spanish"),
     *     @OA\Examples(example="fr", value="fr", summary="French"),
     *   ),
     *
     *   @OA\Response(
     *     response=200,
     *     description="All nodes paginated."
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="An error has happened."
     *   )
     * )
     */
    public function index()
    {
        return new NodeCollection(Node::paginate(10));
    }

    /**
     * Display a listing of the resource.
     * Showing all nodes with children paginated.
     *
     * @return \Illuminate\Http\Response
     *
     * @OA\Get(
     *   path="/api/nodes_with_children",
     *   tags={"nodes"},
     *   summary="All nodes with children paginated",
     *
     *   @OA\Parameter(
     *     name="X-Header-Timezone",
     *     in="header",
     *     description="Get date fields in specific Timezone",
     *     required=false,
     *
     *     @OA\Examples(example="Caracas", value="America/Caracas", summary="Caracas"),
     *     @OA\Examples(example="Bogota", value="America/Bogota", summary="Bogota"),
     *     @OA\Examples(example="Los Angeles", value="America/Los_Angeles", summary="Los Angeles"),
     *   ),
     *
     *   @OA\Parameter(
     *     name="X-Header-Lang",
     *     in="header",
     *     description="Get title field in specific language",
     *     required=false,
     *
     *     @OA\Examples(example="en", value="en", summary="English"),
     *     @OA\Examples(example="es", value="es", summary="Spanish"),
     *     @OA\Examples(example="fr", value="fr", summary="French"),
     *   ),
     *
     *   @OA\Response(
     *     response=200,
     *     description="All nodes with children paginated."
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="An error has happened."
     *   )
     * )
     */
    public function nodes_with_children()
    {
        // $query = Node::has('children', '>', 0)->with('children')->paginate(10);
        $query = Node::has('children', '>', 0)->paginate(10);

        return new NodeCollection($query);
    }

    /**
     * Display a listing of the resource.
     * Showing all nodes without children paginated.
     *
     * @return \Illuminate\Http\Response
     *
     * @OA\Get(
     *   path="/api/nodes_without_children",
     *   tags={"nodes"},
     *   summary="All nodes without children paginated",
     *
     *   @OA\Parameter(
     *     name="X-Header-Timezone",
     *     in="header",
     *     description="Get date fields in specific Timezone",
     *     required=false,
     *
     *     @OA\Examples(example="Caracas", value="America/Caracas", summary="Caracas"),
     *     @OA\Examples(example="Bogota", value="America/Bogota", summary="Bogota"),
     *     @OA\Examples(example="Los Angeles", value="America/Los_Angeles", summary="Los Angeles"),
     *   ),
     *
     *   @OA\Parameter(
     *     name="X-Header-Lang",
     *     in="header",
     *     description="Get title field in specific language",
     *     required=false,
     *
     *     @OA\Examples(example="en", value="en", summary="English"),
     *     @OA\Examples(example="es", value="es", summary="Spanish"),
     *     @OA\Examples(example="fr", value="fr", summary="French"),
     *   ),
     *
     *   @OA\Response(
     *     response=200,
     *     description="All nodes without children paginated."
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="An error has happened."
     *   )
     * )
     */
    public function nodes_without_children()
    {
        // $query = Node::has('children', '>', 0)->with('children')->paginate(10);
        $query = Node::has('children', '=', 0)->paginate(10);

        return new NodeCollection($query);
    }

    // private function has_valid_parent_node(Request $request)
    // {
    //     dd($request);

    // if ($request->parent) {
    //     try {
    //         Node::findOrFail($request->parent);
    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'error' => 'Invalid Parent Node ; Not Found'], 404);
    //     }
    // }
    // }

    /**
     * Store a new created node in storage.
     * Storing a new node in a tree or creating root node for a new tree.
     *
     * @return \Illuminate\Http\Response
     *
     * @OA\Post(
     *   path="/api/nodes",
     *   tags={"nodes"},
     *   summary="Storing a new node",
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="parent",
     *           oneOf={
     *             @OA\Schema(type="string"),
     *             @OA\Schema(type="integer"),
     *           }
     *         ),
     *       ),
     *       example={"parent":null},
     *       example={"parent":"1"},
     *       example={"parent":1},
     *     )
     *   ),
     *
     *   @OA\Parameter(
     *     name="X-Header-Timezone",
     *     in="header",
     *     description="Get date fields in specific Timezone",
     *     required=false,
     *
     *     @OA\Examples(example="Caracas", value="America/Caracas", summary="Caracas"),
     *     @OA\Examples(example="Bogota", value="America/Bogota", summary="Bogota"),
     *     @OA\Examples(example="Los Angeles", value="America/Los_Angeles", summary="Los Angeles"),
     *   ),
     *
     *   @OA\Parameter(
     *     name="X-Header-Lang",
     *     in="header",
     *     description="Get title field in specific language",
     *     required=false,
     *
     *     @OA\Examples(example="en", value="en", summary="English"),
     *     @OA\Examples(example="es", value="es", summary="Spanish"),
     *     @OA\Examples(example="fr", value="fr", summary="French"),
     *   ),
     *
     *   @OA\Response(
     *     response=200,
     *     description="New node created."
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Parent node not found."
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="An error has happened."
     *   )
     * )
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // $this->has_valid_parent_node($request);

        if ($request->parent) {
            try {
                Node::findOrFail($request->parent);
            } catch (\Throwable $th) {
                return response()->json([
                    'error' => 'Invalid Parent Node ; Not Found'], 404);
            }
        }

        $now = new \DateTime('now', new \DateTimeZone('America/Caracas'));
        $now = $now->format('YmdHis');
        // return $now;
        // return now();

        $node = new Node();
        $node->title = 'new node';
        $node->parent = $request->parent;
        $node->save();
        $node = $node->fresh();

        $node->title = get_string_from_number($node->id);
        $node->save();
        $node = $node->fresh();

        return new NodeResource($node);
    }

    /**
     * Display the specified resource.
     * Show a node in the storage.
     *
     * @return \Illuminate\Http\Response
     *
     * @OA\Get(
     *   path="/api/nodes/{id}",
     *   tags={"nodes"},
     *   summary="Showing a node",
     *
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Id to search the node in storage",
     *     required=true,
     *
     *     @OA\Schema(type="string"),
     *
     *     @OA\Examples(example="int", value="1", summary="An integer value."),
     *   ),
     *
     *   @OA\Parameter(
     *     name="X-Header-Timezone",
     *     in="header",
     *     description="Get date fields in specific Timezone",
     *     required=false,
     *
     *     @OA\Examples(example="Caracas", value="America/Caracas", summary="Caracas"),
     *     @OA\Examples(example="Bogota", value="America/Bogota", summary="Bogota"),
     *     @OA\Examples(example="Los Angeles", value="America/Los_Angeles", summary="Los Angeles"),
     *   ),
     *
     *   @OA\Parameter(
     *     name="X-Header-Lang",
     *     in="header",
     *     description="Get title field in specific language",
     *     required=false,
     *
     *     @OA\Examples(example="en", value="en", summary="English"),
     *     @OA\Examples(example="es", value="es", summary="Spanish"),
     *     @OA\Examples(example="fr", value="fr", summary="French"),
     *   ),
     *
     *   @OA\Response(
     *     response=200,
     *     description="Node information."
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Node not found."
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="An error has happened."
     *   )
     * )
     */
    public function show(Node $node)
    {
        $nodeResource = new NodeResource($node);

        return $nodeResource;
    }

    /**
     * Update the specified resource in storage.
     * Update a node information.
     *
     * @return \Illuminate\Http\Response
     *
     * @OA\Patch(
     *   path="/api/nodes/{id}",
     *   tags={"nodes"},
     *   summary="Updating a node",
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="parent",
     *           oneOf={
     *             @OA\Schema(type="string"),
     *             @OA\Schema(type="integer"),
     *           }
     *         ),
     *         @OA\Property(
     *           property="title",
     *           type="string"
     *         ),
     *       ),
     *       example={"parent":null, "title":"un dos tres"},
     *       example={"parent":"1", "title":"un dos tres"},
     *       example={"parent":1, "title":"un dos tres"},
     *     )
     *   ),
     *
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Id to search and update the node in storage",
     *     required=true,
     *
     *     @OA\Schema(type="string"),
     *
     *     @OA\Examples(example="int", value="1", summary="An integer value."),
     *   ),
     *
     *   @OA\Parameter(
     *     name="X-Header-Timezone",
     *     in="header",
     *     description="Get date fields in specific Timezone",
     *     required=false,
     *
     *     @OA\Examples(example="Caracas", value="America/Caracas", summary="Caracas"),
     *     @OA\Examples(example="Bogota", value="America/Bogota", summary="Bogota"),
     *     @OA\Examples(example="Los Angeles", value="America/Los_Angeles", summary="Los Angeles"),
     *   ),
     *
     *   @OA\Parameter(
     *     name="X-Header-Lang",
     *     in="header",
     *     description="Get title field in specific language",
     *     required=false,
     *
     *     @OA\Examples(example="en", value="en", summary="English"),
     *     @OA\Examples(example="es", value="es", summary="Spanish"),
     *     @OA\Examples(example="fr", value="fr", summary="French"),
     *   ),
     *
     *   @OA\Response(
     *     response=200,
     *     description="Node information updated."
     *   ),
     *   @OA\Response(
     *     response=403,
     *     description="Error: Forbidden. Bad Allocation"
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Node not found."
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="An error has happened."
     *   )
     * )
     */
    public function update(Request $request, Node $node)
    {
        // dump($request->all());
        // dd($node->toArray());

        if ($request->parent) {
            try {
                Node::findOrFail($request->parent);
            } catch (\Throwable $th) {
                return response()->json([
                    'error' => 'Invalid Parent Node ; Not Found'], 404);
            }

            if ($request->parent >= $node->id) {
                return response()->json([
                    'error' => 'Invalid Parent Node Allocation'], 403);
            }
        }

        if ($request->title) {
            $node->title = $request->title;
        }

        $node->parent = $request->parent;
        $node->save();
        $node = $node->fresh();

        return new NodeResource($node);
    }

    /**
     * Remove the specified resource from storage.
     * Delete a node in the storage.
     *
     * @return \Illuminate\Http\Response
     *
     * @OA\Delete(
     *   path="/api/nodes/{id}",
     *   tags={"nodes"},
     *   summary="Remove a node",
     *
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Id to search and delete the node in storage",
     *     required=true,
     *
     *     @OA\Schema(type="string"),
     *
     *     @OA\Examples(example="int", value="1", summary="An integer value."),
     *   ),
     *
     *   @OA\Response(
     *     response=204,
     *     description="Deleted: No content."
     *   ),
     *   @OA\Response(
     *     response=403,
     *     description="Error: Forbidden."
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Node not found."
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="An error has happened."
     *   )
     * )
     */
    public function destroy(Node $node)
    {
        if ($node->children()->get()->count() > 0) {
            return response()->json([
                'error' => 'Invalid Deletion Action ; Node Has Children'], 403);
        }

        $node->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
