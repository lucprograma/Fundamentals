class Persona:
    """Este es un ejemplo de una clase en Python"""
    id: int 
    name: str
    def __init__(self, id: int, name: str):
        self.id = id
        self.name = name
class Adulto(Persona):
    """Este es un ejemplo de herencia"""
    edad: int
    def __init__(self, id: int, name: str, edad: int):
        super().__init__(id, name)
        self.edad = edad
    @staticmethod
    def saludar():
        print("Hola soy un adulto")

Adulto(1, "Juan", 30)