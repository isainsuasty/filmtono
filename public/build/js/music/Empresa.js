export class Empresa{
    constructor(id, empresa, id_fiscal, direccion, ciudad, pais, instagram, nombre_comercial, apellido_comercial, email_comercial, tel_comercial, nombre_contable, apellido_contable, email_contable, tel_contable, id_usuario){
        this.id = null;
        this.empresa = empresa;
        this.id_fiscal = id_fiscal;
        this.direccion = direccion;
        this.ciudad = ciudad;
        this.pais = pais;
        this.instagram = instagram;
        this.nombre_comercial = nombre_comercial;
        this.apellido_comercial = apellido_comercial;
        this.email_comercial = email_comercial;
        this.tel_comercial = tel_comercial;
        this.nombre_contable = nombre_contable;
        this.apellido_contable = apellido_contable;
        this.email_contable = email_contable;
        this.tel_contable = tel_contable;
        this.id_usuario = null;
    }
}

export const datosEmpresa = new Empresa();