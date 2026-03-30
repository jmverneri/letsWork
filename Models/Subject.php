<?php
namespace Models;

class Subject {
    private $subjectId;
    private $careerId;
    private $asignatura;
    private $cursado;
    private $hsSemanales;
    private $cargaHorariaTotal;
    private $creditos;
    private $active;

    public function __construct($subjectId = null, $careerId = null, $asignatura = null, $cursado = null, $hsSemanales = null, $cargaHorariaTotal = null, $creditos = null, $active = null) {
        $this->subjectId = $subjectId;
        $this->careerId = $careerId;
        $this->asignatura = $asignatura;
        $this->cursado = $cursado;
        $this->hsSemanales = $hsSemanales;
        $this->cargaHorariaTotal = $cargaHorariaTotal;
        $this->creditos = $creditos;
        $this->active = $active;
    }

    // Getters y Setters
    public function getSubjectId() { return $this->subjectId; }
    public function setSubjectId($subjectId) { $this->subjectId = $subjectId; }

    public function getCareerId() { return $this->careerId; }
    public function setCareerId($careerId) { $this->careerId = $careerId; }

    public function getAsignatura() { return $this->asignatura; }
    public function setAsignatura($asignatura) { $this->asignatura = $asignatura; }

    public function getCursado() { return $this->cursado; }
    public function setCursado($cursado) { $this->cursado = $cursado; }

    public function getHsSemanales() { return $this->hsSemanales; }
    public function setHsSemanales($hsSemanales) { $this->hsSemanales = $hsSemanales; }

    public function getCargaHorariaTotal() { return $this->cargaHorariaTotal; }
    public function setCargaHorariaTotal($cargaHorariaTotal) { $this->cargaHorariaTotal = $cargaHorariaTotal; }

    public function getCreditos() { return $this->creditos; }
    public function setCreditos($creditos) { $this->creditos = $creditos; }
    
    public function getActive() { return $this->active; }
    public function setActive($active) { $this->active = $active; }
}