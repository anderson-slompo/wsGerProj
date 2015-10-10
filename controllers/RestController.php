<?php

namespace wsGerProj\Controllers;

interface RestController {

    public function index();
    
    public function show($id);

    public function create();

    public function update($id);

    public function delete();
}
