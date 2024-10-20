/*
    Excepciones para controlar los errores en nuestra aplicación
*/

//Creamos la base de nuestras excepciones
class BaseException extends Error {
    constructor (message = "", fileName, fileNumber) {
        super(message, fileName, fileNumber);
        this.name = "BaseException";
        if(Error.captureStackTrace) {
            Error.captureStackTrace(this, BaseException);
        }
    }
}

//Recogemos todos los tipos de excepciones que necesitamos

class EmptyValueException extends BaseException {
    constructor(value, fileName, fileNumber) {
        super(
            `[Error] => The ${value} cannnot be empty`,
            fileName,
            fileNumber
        );
        this.name = "EmptyValueException";
        this.value = value;
    }
}

class InvalidConstructorException extends BaseException {
    constructor(value, fileName, fileNumber) {
        super(
            `[Error] => The ${value} cannnot be created without the new operator`,
            fileName,
            fileNumber
        );
        this.name = "InvalidConstructorException";
        this.value = value;
    }
}


class InvalidadArgumentException extends BaseException {
    constructor(value, fileName, fileNumber) {
        super(
            `[Error] => The category is not valid`,
            fileName,
            fileNumber
        );
        this.name = "InvalidadArgumentException";
        this.value = value;
    }
}


class ExistsException extends BaseException {
    constructor(value, fileName, fileNumber) {
        super(
            `[Error] => The category is registered in the map `,
            fileName,
            fileNumber
        );
        this.name = "ExistsException";
        this.value = value;
    }
}

//Exportamos todas las excepciones para poder utilizarlas en otras clases
export { InvalidConstructorException, InvalidadArgumentException, EmptyValueException, ExistsException}
