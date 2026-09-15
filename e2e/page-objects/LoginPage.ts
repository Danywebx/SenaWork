import { Page } from '@playwright/test';

interface Datos {
    correo: string,
    contraseña: string
}

export class LoginPage {
    constructor(
        private page: Page
    ) { }

    async ir(): Promise<void> {
        await this.page.goto('/login');
    }

    async completarDatos(datos: Datos): Promise<void> {
        await this.page.locator('#email').fill(datos.correo);
        await this.page.locator('#password').fill(datos.contraseña);
    }

    async enviar(): Promise<void> {
        await this.page.getByRole('button', { name: 'Iniciar Sesión' }).click();
    }
}
