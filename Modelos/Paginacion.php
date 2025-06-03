<?php

$rootDir = dirname(dirname(__DIR__));
require_once $rootDir . '/CM/Config/DB.php';

class Paginacion
{
    private $db;
    private $titulares;
    private $paginado = 10;
    private $num_paginas;

    /**
     * Constructor: recibe la conexión a la base de datos
     *
     * @param array $datos
     */
    public function __construct(array $datos)
    {
        $this->db = DB::Connect();
        $this->titulares = $datos;
        $this->num_paginas = (int) ceil(count($datos) / $this->paginado);
    }

    // Método para comprobar el array de datos
    public function comprobarArray()
    {
        if (count($this->titulares) == 1) {
            $this->titulares = $this->titulares[0];
        }
        return $this->titulares;
    }

    /**
     * Calculate the number of pages based on the given array of id_titular
     *
     * @param array<int> $id_titular
     * @return int
     */
    public function calcularNumeroPaginas(array $id_titular): int
    {
        // if (count($id_titular) % $this->paginado == 0) {
        //     return count($id_titular) / $this->paginado;
        // } else {
        //     while ((count($id_titular) % $this->paginado) != 0) {
        //         array_push($id_titular, "*");
        //     }
        //     return count($id_titular) / $this->paginado;
        // }
        return (int) ceil(count($id_titular) / $this->paginado);
    }
    public function getNumPaginas()
    {
        return $this->num_paginas;
    }

    /**
     * Método para paginar los datos
     *
     * @param int $numPag
     * @return array
     */
    public function paginar(int $numPag): array
    {
        // $id_titular = $this->titulares;
        // $posicion = 0;
        // $envio = [];

        // if ($numPag == 1 || $numPag == null) {
        //     $titulares_filtrados = array_slice($id_titular, 0, $this->paginado);

        //     foreach ($titulares_filtrados as $id) {
        //         if ($id != "*") {
        //             $sql = "SELECT * FROM Titulares WHERE id_cliente = :id;";
        //             $titulares = $this->db->prepare($sql);
        //             $titulares->execute(['id' => $id['id_cliente']]);
        //             $titulares = $titulares->fetchAll();
        //             foreach ($titulares as $i) {
        //                 array_push($envio, $i);
        //             }
        //         }
        //     }
        // } else {
        //     $posicion = $this->paginado;
        //     $posicion_inicial_registro = $posicion * $numPag - $this->paginado;
        //     $titulares_filtrados = array_slice($id_titular, $posicion_inicial_registro, $this->paginado);

        //     foreach ($titulares_filtrados as $id) {
        //         if ($id != "*") {
        //             $sql = "SELECT * FROM Titulares WHERE id_cliente = :id;";
        //             $titulares = $this->db->prepare($sql);
        //             $titulares->execute(['id' => $id[0]]);
        //             $titulares = $titulares->fetchAll();
        //             foreach ($titulares as $i) {
        //                 array_push($envio, $i);
        //             }
        //         }
        //     }
        // }

        // return $envio;
        $id_titular = $this->titulares;
        $posicion_inicial_registro = ($numPag - 1) * $this->paginado;

        $in = implode(',', array_map(function ($id): string {
            return $id == "*" ? 'NULL' : (string)$id['id_cliente'];
        }, array_slice($id_titular, $posicion_inicial_registro, $this->paginado)));

        $sql = "SELECT * FROM Titulares WHERE id_cliente IN ($in)";
        $titulares = $this->db->prepare($sql);
        $titulares->execute();

        return $titulares->fetchAll();
    }


}
