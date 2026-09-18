import * as path from 'path';
import { Page } from "@playwright/test";

interface Empleo {
    nombre: string,
    categoria: string,
    ubicacion: string,
    foto?: string,
    descripcion: string
}

export class MisEmpleosPage {
    constructor(
        private page: Page
    ) { }

    async ir(): Promise<void> {
        await this.page.getByRole('link', { name: 'Mis empleos' }).click();
    }

    async irCrearEmpleo(): Promise<void> {
        await this.page.getByRole('link', { name: 'Crear Empleo' }).click();
    }

    async crearEmpleo(datos: Empleo): Promise<void> {
        await this.page.locator('#nombre_empleo').fill(datos.nombre);
        await this.page.locator('#categoria').selectOption(datos.categoria);
        await this.page.locator('#ubicacion').fill(datos.ubicacion);
        if (datos.foto) {
            const rutaFoto = path.resolve(import.meta.dirname, datos.foto);
            await this.page.locator('#fotos').setInputFiles(rutaFoto);
        }
        await this.page.locator('#descripcion').fill(datos.descripcion);            
    }

    async enviarEmpleo(): Promise<void> {
        await this.page.getByRole('button', { name: 'Enviar' }).click();
    }
}