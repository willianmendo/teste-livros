import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {

    $('#tabela-assuntos').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
        },
        pageLength: 10,
        order: [[0, 'asc']],
        columnDefs: [
            { orderable: false, targets: -1 }
        ]
    });

    $('#tabela-autores').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
        },
        pageLength: 10,
        order: [[0, 'asc']],
        columnDefs: [
            { orderable: false, targets: -1 }
        ]
    });

    $('#tabela-livros').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
        },
        pageLength: 10,
        order: [[0, 'asc']],
        columnDefs: [
            { orderable: false, targets: -1 }
        ]
    });

    document.getElementById('valor').addEventListener('input', function (e) {
        let valor = e.target.value;
        valor = valor.replace(/\D/g, '');
        if (valor != '') {
            valor = (parseInt(valor, 10) / 100).toFixed(2);
            valor = valor.replace('.', ',');
            valor = valor.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
        e.target.value = valor;
    });

    document.getElementById('anoPublicacao').addEventListener('input', function (e) {
        let valor = e.target.value;
        valor = valor.replace(/\D/g, '');
        if (valor.length > 4) {
            valor = valor.slice(0, 4);
        }
        e.target.value = valor;
        const anoAtual = new Date().getFullYear();
        if (valor && parseInt(valor) > anoAtual) {
            this.setCustomValidity(`O ano não pode ser maior que ${anoAtual}.`);
            this.reportValidity();
        } else {
            this.setCustomValidity('');
        }
    });

    document.getElementById('edicao').addEventListener('input', function (e) {
        let valor = e.target.value;
        valor = valor.replace(/\D/g, '');
        if (valor.length > 10) {
            valor = valor.slice(0, 10);
        }
        e.target.value = valor;
    });

    $('.select2').select2({
        theme: 'bootstrap-5',
        placeholder: 'Selecione uma opção',
        width: '100%'
    });
});