async function getDB() {
    console.log("Reading data from connection...");
    let cn = { connection: '127.0.0.1' };
    return await new Promise(resolve => setTimeout(() => resolve(cn), 2000));
}

async function setData(db) {
    console.log('Receiving data from ' + db.connection);
    if (db.connection === '127.0.0.1') {
        return Promise.resolve([
            { registro: 'Registro número 1' },
            { registro: 'Registro número 2' }
        ]);
    } else {
        return Promise.reject(new Error('Error in database server'));
    }
}

function showData(data) {
    console.log('Processing data...');
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            if (data.length > 0) {
                resolve(() => console.log(data));
            } else {
                reject(new Error('No data'));
            }
        }, 2000);
    });
}
const dbPromise = getDB().then(Response => { return setData(Response) }).then(data => {
    return showData(data);
}
).then(show => {
    show();
}).catch(err => {
    console.log(err);
});