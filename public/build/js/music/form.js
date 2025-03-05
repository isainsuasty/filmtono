import { validarFormulario } from "../base/funciones.js";
export const form = document.createElement('form');
form.classList.add('form');

const campos = [
    {
        id: 'empresa',
        type: 'text',
        placeholder: 'Nombre de la Empresa',
        name: 'empresa',
        label: 'Nombre de la Empresa'
    },
    {
        id: 'id_fiscal',
        type: 'text',
        placeholder: 'Número de Id. Fiscal',
        name: 'id_fiscal',
        label: 'Id. Fiscal'
    },
    {
        id: 'direccion',
        type: 'text',
        placeholder: 'Dirección de la empresa',
        name: 'direccion',
        label: 'Dirección'
    },
    {
        id: 'ciudad',
        type: 'text',
        placeholder: 'Ciudad',
        name: 'ciudad',
        label: 'Ciudad'
    },
    {
        id: 'pais',
        type: 'text',
        placeholder: 'País',
        name: 'pais',
        label: 'País'
    },
    {
        id: 'instagram',
        type: 'text',
        placeholder: 'Instagram',
        name: 'instagram',
        label: 'Instagram'
    },
    {
        id: 'nombre_comercial',
        type: 'text',
        placeholder: 'Nombre del responsable comercial',
        name: 'nombre_comercial',
        label: 'Nombre del responsable comercial'
    },
    {
        id: 'apellido_comercial',
        type: 'text',
        placeholder: 'Apellido del responsable comercial',
        name: 'apellido_comercial',
        label: 'Apellido del responsable comercial'
    },
    {
        id: 'email_comercial',
        type: 'email',
        placeholder: 'Email del responsable comercial',
        name: 'email_comercial',
        label: 'Email del responsable comercial'
    },
    {
        id: 'tel_comercial',
        type: 'tel',
        placeholder: 'Teléfono del responsable comercial',
        name: 'tel_comercial',
        label: 'Teléfono del responsable comercial'
    },
    {
        id: 'nombre_contable',
        type: 'text',
        placeholder: 'Nombre del responsable contable',
        name: 'nombre_contable',
        label: 'Nombre del responsable contable'
    },
    {
        id: 'apellido_contable',
        type: 'text',
        placeholder: 'Apellido del responsable contable',
        name: 'apellido_contable',
        label: 'Apellido del responsable contable'
    },
    {
        id: 'email_contable',
        type: 'email',
        placeholder: 'Email del responsable contable',
        name: 'email_contable',
        label: 'Email del responsable contable'
    },
    {
        id: 'tel_contable',
        type: 'tel',
        placeholder: 'Teléfono del responsable contable',
        name: 'tel_contable',
        label: 'Teléfono del responsable contable'
    }
];

campos.forEach(campo => {
    const div = document.createElement('div');
    div.classList.add('form__group');

    const label = document.createElement('label');
    label.classList.add('form__group__label');
    label.setAttribute('for', campo.id);
    label.textContent = campo.label;

    const input = document.createElement('input');
    input.classList.add('form__group__input');
    input.setAttribute('type', campo.type);
    input.setAttribute('placeholder', campo.placeholder);
    input.setAttribute('name', campo.name);
    input.setAttribute('id', campo.id);
    input.addEventListener('blur', validarFormulario);
     

    div.appendChild(label);
    div.appendChild(input);

    form.appendChild(div);
});
