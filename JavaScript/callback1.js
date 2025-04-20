function getDB(user, password, db) {
    if (user === 'TEST' && password === 'test123') {
        setTimeout(function () {
            console.log("Reading data from connection...");
            db({ state: 'success' });
        }, 2000);
    } else {
        throw new Error('Invalid credentials');
    }
}

function setData(db, data) {
    if (db.state === 'success') {
        setTimeout(function () {
            console.log("Reading data from database...");
            data([
                { registro: 'Registro número 1' },
                { registro: 'Registro número 2' }
            ]);
            return data;
        }, 1000);
    } else {
        throw new Error('Error from database server');
    }
}

function showData(data, show) {
    setTimeout(function () {
        console.log("Processing..." + data[0].registro + '...');
        show(function () {
            console.log(data);
        });
    }, 1000);
}
getDB('TEST', 'test123', (db) => {
    setData(db, (data) => {
        showData(data, (show) => {
            show();
        });
    })})