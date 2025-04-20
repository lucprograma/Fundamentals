// async function transaction() {
//     console.log("Reading data from connection...");
//     let cn = { connection: '127.0.0.1' };
//     await new Promise(resolve => setTimeout(resolve, 2000));
//     console.log('Receiving data from ' + cn.connection);
//     let data;
//     if (cn.connection === '127.0.0.1') {
//         data = [
//             { registro: 'Registro número 1' },
//             { registro: 'Registro número 2' }
//         ];
//     } else {
//         throw new Error('Error in database server');
//     }
//     console.log('Processing data...');
//     await new Promise(resolve => setTimeout(resolve, 2000));
//     if (data.length > 0) {
//         console.log(data);
//     } else {
//         throw new Error('No data');
//     }
// }
async function connect(){
    console.log("Reading data from connection...");
    let cn = { connection: '127.0.0.1' };
    await new Promise(resolve => setTimeout(resolve, 2000));
    console.log('Receiving data from ' + cn.connection);
    return cn;
}
async function getData(){
    const cn = await connect();
    let data;
    if (cn.connection === '127.0.0.1') {
        data = [
            { registro: 'Registro número 1' },
            { registro: 'Registro número 2' }
        ];
        return data;
    } else {
        throw new Error('Error in database server');
    }
    console.log('Processing data...');
}
async function showData(){
    const data = await getData();
    await new Promise(resolve => setTimeout(resolve, 2000));
         if (data.length > 0) {
             console.log(data);
         } else {
             throw new Error('No data');
         }
}

showData();