<?php

class CompraEstadoTipo
{
    private $idCompraEstadoTipo;
    private $cetDescripcion;
    private $cetDetalle;
    private $mensaje;

    //Magic Methods
    public function __construct()
    {
        $this->idCompraEstadoTipo = "";
        $this->cetDescripcion = "";
        $this->cetDetalle = "";
        $this->mensaje = "";
    }


    //Setters
    public function setIdCompraEstadoTipo($idCompraEstadoTipo)
    {
        $this->idCompraEstadoTipo = $idCompraEstadoTipo;
    }

    public function setCetDescripcion($cetDescripcion)
    {
        $this->cetDescripcion = $cetDescripcion;
    }

    public function setCetDetalle($cetDetalle)
    {
        $this->cetDetalle = $cetDetalle;
    }

    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
    }


    //Getters
    public function getIdCompraEstadoTipo()
    {
        return $this->idCompraEstadoTipo;
    }

    public function getCetDescripcion()
    {
        return $this->cetDescripcion;
    }

    public function getCetDetalle()
    {
        return $this->cetDetalle;
    }

    public function getMensaje()
    {
        return $this->mensaje;
    }
}
