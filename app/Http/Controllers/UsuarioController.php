<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class UsuarioController extends BaseController
{
  
    /**Função para validar o usuário e retornar o token de autenticação
     * 
     * @param Request $request
     * @return type
     */
    public function login(Request $request) 
    {

        $rules = array(
            'email' => 'required|email|max:255',
            'password' => 'required'
        );
        $this->validate($request, $rules);
        

        //adiciono a informação de e-mail ao token
        if(!$token = $this->jwt->claims(['email' => $request->email])->attempt($request->only('email','password'))){
            return response()->json(['Usuario ou senha não encontrado'], 404);
        }
     
        return response()->json(compact('token'));    
    }
    
    /**
     * Função para mostrar os dados do usuário autenticado via token
     * @return type
     */
    public function mostrarUsuarioAutenticado() 
    {
        $usuario = Auth::user();
        return response()->json($usuario);
    }
    
    /**
     * Função para cadastrar um usuário
     * @param Request $request
     * @return type
     */
    public function cadastrarUsuario(Request $request) 
    {
        //validação
        $rules = array(
            'name' => 'required|min:5|max:40',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        );
        
        $this->validate($request, $rules);

        $usuario = new \App\User();
        
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password);
        $usuario->save();
        
        return response()->json($usuario);      
    }
    
    /**
     * Função para realizar o logout do usuário
     * @return type
     */
    public function usuarioLogout() 
    {
        Auth::logout();
        return response()->json('Usuário deslogado com sucesso!');
    }
    
}
