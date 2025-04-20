//constantes 
const file_path = "...";
showVar(file_path);
// Variables
function localScope(){
    if(true){
    let localVar = "Hello from let";
    showVar(localVar);
    var globalVar = "Hello from var";
    }
    showVar(globalVar); // undefined
    // La diferencia entre var y let es el scope siendo var global dentro de la función y let local dentro del bloque
}
function showVar(variable){
    console.log(variable);
}
localScope();