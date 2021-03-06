new Vue({
    el: '#CarrerasCRUD',
    created: function () {
        this.getCarreras();
        toastr.options ={
            showMethod: 'fadeIn', //fadeIn, slideDown, and show are built into jQuery
            showDuration: 500,
            showEasing: 'swing',
            hideMethod: 'fadeOut',
            hideDuration: 1000,
            hideEasing: 'swing',
            onHidden: undefined,
            closeMethod: false,
            closeDuration: false,
            closeEasing: false,
            closeOnHover: true,
            progressBar: true
        };
        $('[data-toggle="tooltip"]').tooltip();
    },

    data: {
        url: 'carrera',
        carreras: [],
        ClaveCarrera: '',
        NombreCarrera: '',
        fillCarrera: {'Clave': '', 'Nombre': ''},
        pagination: {
            'total': 0,
            'current_page': 0,
            'per_page': 0,
            'last_page': 0,
            'from': 0,
            'to': 0,
        },
        offset: 3,
        errors: [],
        search: '',
    },
    computed: {
        isActived: function () {
            return this.pagination.current_page;
        },
        pageNumber: function () {
            if (!this.pagination.to) {
                return [];
            }
            var from = this.pagination.current_page - this.offset; //TODO offset
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2); //TODO offset
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }

            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        },


    },
    methods: {
        changePage: function (page) {
            this.pagination.current_page = page;
            this.getCarreras(page);
        },
        searchCarrera: function () {
            var search = $("#search").val();
            this.search = search;
            this.getCarreras();
        },

        //Modulo Carreras
        getCarreras: function (page) {
            var url = this.url + '?page=' + page + '&search=' + this.search;
            axios.get(url).then(response => {
                this.carreras = response.data.carreras.data;
                this.pagination = response.data.pagination;
            });
        },
        deleteCarrera: function (carrera) {
            if (confirm('¿Esta seguro de eliminar la carrera: ' + carrera.Nombre + '?')) {
                var url = this.url + '/' + carrera.Clave;
                axios.delete(url).then(response => {
                    this.getCarreras();
                    swal.close();
                    toastr.success("La carrera ha sido eliminada con exito.", "Tarea completada!");
                }).catch(ex => {
                    //ex.response.data.message
                    toastr.error('Hubo un problema y no se pudo completar la acción', "Error!");
                });
            }
        },
        limpiar: function() {
            this.ClaveCarrera = '';
            this.NombreCarrera = '';
            this.errors = [];
        },
        createCarrera: function () {
            var url = this.url;
            this.errors = [];
            var condition = 0;
            this.carreras.forEach( carrera => {
                if ( carrera.Nombre.toString().toLowerCase().localeCompare(this.NombreCarrera.toString().toLowerCase()) == 0 ){
                    condition = 1;
                }
            });
            if (condition != 1){
                axios.post(url, {
                    Clave: this.ClaveCarrera,
                    Nombre: this.NombreCarrera,
                    Existe: 1
                }).then(response => {
                    this.getCarreras();
                    this.ClaveCarrera = '';
                    this.NombreCarrera = '';
                    this.errors = [];
                    $('#createCarrera').modal('hide');
                    toastr.success("Carrera registrada con exito.", "Tarea completada!");
                }).catch(error => {
                    this.errors = 'Error: Hubo un problema y no se pudo completar la acción';//error.response.data.message;
                    toastr.error('Hubo un problema y no se pudo completar la acción', "Error!");
                });
            }else{
                toastr.error('Esta carrera ya existe, no es posible agregarla de nuevo','Aviso!');
                this.errors = 'Esta carrera ya existe, no es posible agregarla de nuevo';
            }
        },
        editCarrera: function (carrera) {
            this.fillCarrera.Clave  = carrera.Clave;
            this.fillCarrera.Nombre = carrera.Nombre;
            this.errors = [];
            $('#editCarrera').modal('show');
        },
        updateCarrera: function (id) {
            var url = this.url + '/' + id;
            this.errors = [];
            var condition = 0;
            this.carreras.forEach( carrera => {
                if ( carrera.Nombre.toString().toLowerCase().localeCompare(this.fillCarrera['Nombre'].toString().toLowerCase()) == 0 ){
                    condition = 1;
                }
            });
            if (condition != 1){
                axios.put(url, this.fillCarrera).then(response => {
                    this.getCarreras();
                    this.fillCarrera = {'Clave': '', 'Nombre': ''};
                    this.errors = [];
                    $('#editCarrera').modal('hide');
                    toastr.success("Carrera actualizada con exito.", "Tarea completada!");
                }).catch(error => {
                    this.errors = 'Hubo un problema y no se pudo completar la acción';//error.response.data.message;
                    toastr.error('Hubo un problema y no se pudo completar la acción', "Error!");
                });
            }else{
                toastr.error('Esta carrera ya existe, no es posible realizar el cambio','Aviso!');
                this.errors = 'Esta carrera ya existe, no es posible realizar el cambio';
            }
        },

    }
});
