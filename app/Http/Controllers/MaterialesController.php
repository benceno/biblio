<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Materiales;


class MaterialesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function index(Request $request)
    {   
        $search = $request->get('search');

        $materiales = Materiales::join('tblcarreras', 'tblcarreras.Clave', '=', 'tblmateriales.IdCarrera')
                ->select(
                    'tblmateriales.Id',
                    'tblmateriales.Titulo',
                    'tblcarreras.Nombre as Clave',
                    'tblmateriales.IdCarrera as IdCarrera',
                    'tblmateriales.year as Year',
                    'tblmateriales.Ejemplares',
                    'tblmateriales.Tipo'
                )
                ->where('tblmateriales.Existe', '=', 1)
                ->orderby('id', 'DESC')
                ->search($search)
                ->paginate(10); 
        return [
            'pagination' => [
                'total'         => $materiales->total(),
                'current_page'  => $materiales->currentPage(),
                'per_page'      => $materiales->perPage(),
                'last_page'     => $materiales->lastPage(),
                'from'          => $materiales->firstItem(),
                'to'            => $materiales->lastItem(),
            ],
            'material' =>$materiales
        ];
    }


    public function cla()
    {   
        $claves= DB::table('tblcarreras')->get();
        return view('Materiales.principal', compact('claves'));
    }
    public function getCarreras()
    {
        $claves= DB::table('tblcarreras')->get();
        return $claves;
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
      $this->validate($request, [
        'Titulo' => 'required',
        'IdCarrera' => 'required',
        'Year' => 'required',
        'Ejemplares' => 'required',
        'Tipo' => 'required'
      ]);

      Materiales::create($request->all());

      return;

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
        $this->validate($request, [
            'Titulo' => 'required',
            'IdCarrera' => 'required',
            'Year' => 'required',
            'Ejemplares' => 'required',
            'Tipo' => 'required'
        ]);

        Materiales::where('Id', '=', $id)->update($request->all());
    }

    
    //Remove the specified resource from storage.
    public function destroy($id)
    {
        $material = Materiales::findOrFail($id);
        $material->Existe = 0;
        $material->save();
    }
}