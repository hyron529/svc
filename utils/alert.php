<?php 
class AlertGenerator { 
    public function dangerAlert($text) {
        return "
        <div class='alert alert-danger alert-dismissible fade show' role='alert'>
            $text
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
      ";
    }

    public function successAlert($text) {
        return "
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
            $text
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
      ";
    }
}