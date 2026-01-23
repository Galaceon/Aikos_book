<?php

namespace Classes;

class Paginacion {
    public $pagina_actual;
    public $registros_por_pagina;
    public $total_registros;

    public function __construct($pagina_actual = 1, $registros_por_pagina = 10, $total_registros = 0)
    {
       $this->pagina_actual = (int) $pagina_actual;
       $this->registros_por_pagina = (int) $registros_por_pagina;
       $this->total_registros = (int) $total_registros;
    }

    // Obtiene el total de registros a mostrar (9 x (3-1) = 9 x 2 = 18, saltate 18 registros y empieza a mostrar desde el 19)
    public function offset() {
        return $this->registros_por_pagina * ($this->pagina_actual -1);
    }

    // Calcula el total de paginas, ej: 40 / 10 = 4 paginas (40registros, 10 por pagina)
    public function total_paginas() {
        return ceil($this->total_registros / $this->registros_por_pagina);
    }

    // Obtiene la pagina anterior y si no existe regresa false
    public function pagina_anterior() {
        $anterior = $this->pagina_actual - 1;
        return($anterior > 0) ? $anterior : false;
    }

    // Obtiene la pagina siguiente y si no existe regresa false
    public function pagina_siguiente() {
        $siguiente = $this->pagina_actual + 1;
        return($siguiente <= $this->total_paginas()) ? $siguiente : false;
    }

    public function enlace_anterior() {
        $html = '';
        if($this->pagina_anterior()) {
            $html .= "<a class=\"paginacion__enalce paginacion__enlace--texto\" href=\"?page={$this->pagina_anterior()}\">&laquo; Anterior</a>";
        }
        return $html;
    }

    public function enlace_siguiente() {
        $html = '';
        if($this->pagina_siguiente()) {
            $html .= "<a class=\"paginacion__enalce paginacion__enlace--texto\" href=\"?page={$this->pagina_siguiente()}\">Siguiente &raquo;</a>";
        }
        return $html;
    }

    public function numeros_paginas() {
        $html = '';

        for($i = 1; $i <= $this->total_paginas(); $i++) {
            if($i === $this->pagina_actual) {
                $html .= "<span class=\"paginacion__enlace paginacion__enlace--actual\">{$i}</span>";
            } else {
                $html .= "<a class=\"paginacion__enlace paginacion__enlace--numeros\" href=\"?page={$i}\">{$i}</a>";
            }
        }

        return $html;
    }

    public function paginacion() {
        $html = '';
        if($this->total_registros > 1) {
            $html .= '<div class="paginacion">';
            
            $html .= $this->enlace_anterior();
            $html .= $this->numeros_paginas();
            $html .= $this->enlace_siguiente();

            $html .= '</div>';
        }

        return $html;
    }
}