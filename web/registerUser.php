<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="register-card p-5">
        <h2 class="text-center mb-4">
            <span class="text-red">R</span>EGISTRO <span class="text-red">D</span>E <span class="text-red">U</span>SUARIO
        </h2>
        <form>
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" placeholder="Introduce tu nombre">
            </div>
            <div class="mb-3">
                <label for="surname" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="surname" placeholder="Introduce tus apellidos">
            </div>
            <div class="mb-3">
                <label for="dob" class="form-label">Fecha de nacimiento</label>
                <input type="date" class="form-control" id="dob">
            </div>
            <div class="mb-3">
                <label class="form-label">Carnet de conducir</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="drivingLicense" id="yes" value="yes">
                        <label class="form-check-label" for="yes">Sí</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="drivingLicense" id="no" value="no">
                        <label class="form-check-label" for="no">No</label>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="nationality" class="form-label">Nacionalidad</label>
                <input type="text" class="form-control" id="nationality" placeholder="Introduce tu nacionalidad">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" placeholder="Introduce tu correo">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" placeholder="Introduce una contraseña">
            </div>
            <div class="d-grid gap-2 mb-3">
                <button type="submit" class="btn btn-primary">Registrarse</button>
            </div>
        </form>
    </div>
</div>
