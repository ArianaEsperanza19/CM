<?php

$rootDir = dirname(dirname(__DIR__));
require_once $rootDir . '/CustomersManager/Config/DB.php';

class Paginacion
{
    private $db;
    private $titulares;
    private $paginado = 6;
    private $num_paginas;

    // Constructor: recibe la conexión a la base de datos
    public function __construct($datos)
    {
        $this->db = DB::Connect();
        $this->titulares = $datos;
        $this->calcularNumeroPaginas();

    }

    // Método para comprobar el array de datos
    public function comprobarArray()
    {
        if (count($this->titulares) == 1) {
            $this->titulares = $this->titulares[0];
        }
        return $this->titulares;
    }

    public function calcularNumeroPaginas()
    {
        $id_titular = $this->titulares;
        if (count($id_titular) % $this->paginado == 0) {
            $this->num_paginas = count($id_titular) / $this->paginado;
        } else {
            while ((count($id_titular) % $this->paginado) != 0) {
                array_push($id_titular, "*");
            }
            $this->num_paginas = count($id_titular) / $this->paginado;
        }
        return $this->num_paginas;
    }
    public function getNumPaginas()
    {
        return $this->num_paginas;
    }

    // Método para paginar los datos
    public function paginar($numPag)
    {

        $id_titular = $this->titulares;
        $posicion = 0;
        $envio = [];

        if ($numPag == 1 || $numPag == null) {
            $titulares_filtrados = array_slice($id_titular, 0, $this->paginado);

            foreach ($titulares_filtrados as $id) {
                if ($id != "*") {
                    $sql = "SELECT * FROM Titulares WHERE id_cliente = :id;";
                    $titulares = $this->db->prepare($sql);
                    $titulares->execute(['id' => $id['id_cliente']]);
                    $titulares = $titulares->fetchAll();
                    foreach ($titulares as $i) {
                        array_push($envio, $i);
                    }
                }
            }
        } else {
            $posicion = $this->paginado;
            $posicion_inicial_registro = $posicion * $numPag - $this->paginado;
            $titulares_filtrados = array_slice($id_titular, $posicion_inicial_registro, $this->paginado);

            foreach ($titulares_filtrados as $id) {
                if ($id != "*") {
                    $sql = "SELECT * FROM Titulares WHERE id_cliente = :id;";
                    $titulares = $this->db->prepare($sql);
                    $titulares->execute(['id' => $id[0]]);
                    $titulares = $titulares->fetchAll();
                    foreach ($titulares as $i) {
                        array_push($envio, $i);
                    }
                }
            }
        }

        return $envio;
    }


}

// $db = new DB();
// $db = $db->Connect();
// $paginas = 0;
// $id_titular = [];
// $datos = $db->prepare("SELECT id_cliente FROM Titulares;");
// $datos->execute();
// $datos = $datos->fetchAll();
//
// $Paginacion = new Paginacion($datos);
// echo $Paginacion->calcularNumeroPaginas();
// $paginado = $Paginacion->paginar(2, $datos);
// echo "<pre>";
// print_r($paginado);
// echo "</pre>";
// echo $Paginacion->getNumPaginas();
