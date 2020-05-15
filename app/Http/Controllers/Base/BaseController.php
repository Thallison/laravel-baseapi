<?php

namespace App\Http\Controllers\Base;

use Laravel\Lumen\Routing\Controller;

class BaseController extends Controller
{
    
    protected $ocorreuErro; 
    protected $descricaoErro; 
    protected $ocorreuAlerta; 
    protected $descricaoAlerta; 
   
    /**
     * Setar variaveis como sucesso
     */
    private function setRetornoSucesso() 
    {
        $this->ocorreuErro = "false"; 
        $this->descricaoErro = null; 
        $this->ocorreuAlerta = "false"; 
        $this->descricaoAlerta = null; 
    }
    
    /**
     * Setar variaveis como alerta
     * @param type $msg
     */
    private function setRetornoAlerta($msg) 
    {
        $this->ocorreuErro = "false"; 
        $this->descricaoErro = null; 
        $this->ocorreuAlerta = "true"; 
        $this->descricaoAlerta = $msg; 
    }
    
    /**
     * Setar variaveis como erro
     * @param type $msg
     */
    private function setRetornoErro($msg) 
    {
        $this->ocorreuErro = "true"; 
        $this->descricaoErro = $msg; 
        $this->ocorreuAlerta = "false"; 
        $this->descricaoAlerta = null; 
    }
    
    /**
     * Função para setar o tipo de retorno da mensagem como sucesso
     * @param type $data
     * @return type json
     */
    protected function setSucesso($data = '')
    {
        $this->setRetornoSucesso();
        return $this->montaJSON(array('data' => $data));
    }
    
    /**
     * Função para setar o tipo de retorno da mensagem como alerta
     * @param type $msg
     * @return type json
     */
    protected function setAlerta($msg)
    {
        $this->setRetornoAlerta($msg);
        return $this->montaJSON();
    }
    
    /**
     * Função para setar o tipo de retorno da mensagem como erro
     * @param type $msg
     * @return type json
     */
    protected function setErro($msg)
    {
        $this->setRetornoErro($msg);
        return $this->montaJSON();
    }
    
    /**
     * Função para criar o json padrão de retorno
     * @param array $data
     * @return type json
     */
    private function montaJSON(array $data = array()) 
    {
        $arrayMsg = [
            'ocorreuErro' => $this->ocorreuErro,
            'descricaoErro' => $this->descricaoErro,
            'ocorreuAlerta' => $this->ocorreuAlerta,
            'descricaoAlerta' => $this->descricaoAlerta
        ];
        
        $data = array_merge($arrayMsg,$data);
        
        return response()->json($data); 
    }

}