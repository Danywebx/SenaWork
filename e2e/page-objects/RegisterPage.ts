import { Page } from '@playwright/test';

interface Datos {
    nombres: string,
    apellidos: string,
    tipoDocumento: 'Cédula de ciudadanía' | 'Cédula de extranjería',
    numeroDocumento: string,
    fechaNacimiento: string,
    celular: string,
    direccion: string,
    correo: string,
    contraseña: string,
    categoria: string,
    rol: 'Empleado' | 'Empleador',
}

export class RegisterPage {
    constructor(
        private page: Page
    ) { }

    async ir(): Promise<void> {
        await this.page.goto('/registro');
    }

    async completarDatos(datos: Datos): Promise<void> {
        await this.page.getByRole('textbox', { name: 'Nombres:' }).fill(datos.nombres);
        await this.page.getByRole('textbox', { name: 'Apellidos:' }).fill(datos.apellidos);
        await this.page.locator('#tipo_documento').selectOption(datos.tipoDocumento);
        await this.page.getByRole('spinbutton', { name: 'Número de documento:' }).fill(datos.numeroDocumento);
        await this.page.locator('#fecha_nacimiento').fill(datos.fechaNacimiento);
        await this.page.getByRole('spinbutton', { name: 'Celular:' }).fill(datos.celular);
        await this.page.locator('#direccion').fill(datos.direccion);
        await this.page.locator('#email').fill(datos.correo);
        await this.page.locator('#password').fill(datos.contraseña);
        await this.page.locator('#password_confirmation').fill(datos.contraseña);
        await this.page.locator('#categoria').selectOption(datos.categoria);
        await this.page.getByRole('checkbox', { name: datos.rol, exact: true }).check();
    }

    async aceptarTerms(): Promise<void> {
        await this.page.getByRole('checkbox', { name: 'Acepto los términos y' }).check();
    }

    async enviar(): Promise<void> {
        await this.page.getByRole('button', { name: 'Crear cuenta' }).click();
    }
}
