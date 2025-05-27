## Comparision
$gt: Esto permite obtener los registros mayores a 
```
{field : {$gt: value}}
```
$gte: Este es mayor o igual que el valor especificado
$eq: Igual
```
{ <field>: { $eq: <value> } }
```
$it: Menor a dicho valor
$ite: Menos o igual al valor
## booleanos
$or
db.collection.find($or: {"fiel": "condition"})
## actualización 
$push se utiliza para agregar campos a las colletions
db.collection.findOneUpdate(_id: ObjectID(""), {$push: {"field": value}})
$pull para eliminar
db.collection.findOneUpdate(_id: ObjectID(""), {$pull: {"field": value}})

## Agregación
$lookup: Similar al join en SQL
db.collection.aggregation(
    $lookup:
     {
       from: <collection to join>,
       localField: <field from the input documents>,
       foreignField: <field from the documents of the "from" collection>,
       let: { <var_1>: <expression>, …, <var_n>: <expression> },
       pipeline: [ <pipeline to run> ],
       as: <output array field>
     }
)