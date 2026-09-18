import { Page } from '@playwright/test';

export class InicioPage {
    constructor(
        private page: Page
    ) { }

    async ir(): Promise<void> {
        await this.page.goto('/empleado');
    }

    async obtenerRol(): Promise<'Empleado' | 'Empleador'> {
        const esEmpleado = await this.page
            .getByRole('button', { name: 'Empleado', exact: true })
            .evaluate(btn => btn.classList.contains('btn-light'));

        return esEmpleado ? 'Empleado' : 'Empleador';
    }

    async cerrarSesion(): Promise<void> {
        await this.page.getByRole('link', { name: 'Profile' }).click();
        await this.page.getByRole('button', { name: 'Cerrar sesión' }).click();
    }

    async cambiarRol(): Promise<void> {
        const rolActual = await this.obtenerRol();
        const nuevoRol = rolActual === 'Empleado' ? 'Empleador' : 'Empleado';
        await this.page.getByRole('button', { name: nuevoRol, exact: true }).click();
    }
}
