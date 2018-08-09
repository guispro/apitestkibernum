<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use App\History;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Producto::orderBy('cantidad','desc')->limit(20)->get();


        foreach ($productos as $producto) {
            // $history = new History;
            $keywords = '';
            $history = History::select('keyword')->where('producto_id', $producto->id)->orderBy('busquedas','desc')->limit(5)->get();
            foreach ($history as $key => $value) {
                $keywords .=  $value->keyword . ',';
            }
            $response[] = [$producto->nombre, $keywords];
        }

        $data = [
            'analisis'=>$response,
        ];

        echo json_encode($data);
    }

    public function search(Request $keyword){
        
        $params = $keyword->json()->all();
        if($params['limit'] < 50 || $params['limit'] > 0){
            $limit = $params['limit'];
        }else{
            $limit = 50;
        }
        $productos = Producto::select()->where('nombre', 'like','%'. $params['keyword'] .'%')->limit($limit)->get();

        foreach ($productos as $producto) {
            $history = new History;
            Producto::where('id', $producto->id)->increment('busquedas');
            if(History::where('producto_id',$producto->id)->where('keyword',$params['keyword'])->exists()){
                $history->where('producto_id',$producto->id)->where('keyword',$params['keyword'])->increment('cantidad');
            }else{
                $history->producto_id = $producto->id;
                $history->keyword = $params['keyword'];
                $history->busquedas = 1;
                $history->save();
            }
        }

        $data = [
            'result'=>$productos
        ];

        echo json_encode($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'keyword'=>$request->json(),
        ];

        echo json_encode($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
