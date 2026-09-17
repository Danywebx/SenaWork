import * as path from 'path';
import { Page, expect } from "@playwright/test";

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
        await expect(this.page.locator('#cardModal1')).toBeVisible();

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
        // await this.page.getByRole('dialog', { name: 'Eliminar cuenta ¿Estás seguro' }).click();
        // await this.page.locator('.modal-content').first().click();
    }
}
