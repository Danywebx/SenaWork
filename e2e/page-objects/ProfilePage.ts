import * as path from 'path';
import { Page } from "@playwright/test";

interface Contrasenas {
    claveAntigua: string,
    claveNueva: string
}

interface editarPerfil {
    foto?: string,
    telefono?: string,
    portafolio?: string,
    categoria?: string,
}

export class ProfilePage {
    constructor(
        private page: Page
    ) { }

    async ir(): Promise<void> {
        await this.page.getByRole('link', { name: 'Profile' }).click();
        await this.page.getByRole('link', { name: 'Mi Perfil' }).click();
    }

    async completarPerfil(): Promise<void> {
        const rutaDocumento = path.resolve(import.meta.dirname, '../data/Prueba_Documento_de_Identidad.pdf');
        const rutaAntecedentes = path.resolve(import.meta.dirname, '../data/Prueba_Documento_de_Antecedentes_Judiciales.pdf');
        const rutaPortafolio = path.resolve(import.meta.dirname, '../data/Prueba_Documento_de_Portafolio.pdf');

        await this.page.getByRole('button', { name: 'Completar perfil' }).click();

        const modal = this.page.locator('#cardModal1');
        await modal.locator('#documentoIdentidad').setInputFiles(rutaDocumento);
        await modal.locator('#antecedentes').setInputFiles(rutaAntecedentes);
        await modal.locator('#portafolio').setInputFiles(rutaPortafolio);
    }

    async enviar(): Promise<void> {
        await this.page.locator('#cardModal1').getByRole('button', { name: 'Enviar' }).click();
    }

    async eliminarCuenta(): Promise<void> {
        await this.page.locator('a').filter({ hasText: 'Eliminar cuenta' }).click();
        await this.page.getByRole('button', { name: 'Aceptar' }).click();
    }

    async cambiarContrasena(claves: Contrasenas): Promise<void> {
        await this.page.getByRole('tab', { name: 'Cambiar contraseña' }).click();
        await this.page.getByRole('textbox', { name: 'Contraseña actual' }).fill(claves.claveAntigua);
        await this.page.getByRole('textbox', { name: 'Nueva contraseña', exact: true }).fill(claves.claveNueva);
        await this.page.getByRole('textbox', { name: 'Confirmar nueva contraseña' }).fill(claves.claveNueva);
        await this.page.getByRole('button', { name: 'Cambiar contraseña' }).click();
    }

    async editarPerfil(datos: editarPerfil): Promise<void> {
        await this.page.getByRole('tab', { name: 'Editar Perfil' }).click();

        if (datos.foto) {
            const rutaFoto = path.resolve(import.meta.dirname, datos.foto);
            await this.page.locator('#profileImageUpload').setInputFiles(rutaFoto);
        }
        if (datos.telefono) {
            await this.page.getByRole('textbox', { name: 'Celular:' }).fill(datos.telefono);
        }
        if (datos.portafolio) {
            const rutaPortafolio = path.resolve(import.meta.dirname, datos.portafolio);
            await this.page.locator('#portafolioUpload').setInputFiles(rutaPortafolio);
        }
        if (datos.categoria) {
            await this.page.locator('#categoria').selectOption(datos.categoria);
        }

        await this.page.getByRole('button', { name: 'Guardar cambios' }).click();
    }    
}
