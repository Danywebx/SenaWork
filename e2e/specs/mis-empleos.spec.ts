import { test, expect } from '../fixtures/fixtures';
import { MisEmpleosPage } from '../page-objects/MisEmpleosPage';

test.describe('Tests de la página Mis empleos - Rol Empleador', () => {

    test.beforeEach(async ({ registrarUsuarioEmpleador, completarPerfil, page }) => {
        const misEmpleosPage = new MisEmpleosPage(page);

        await test.step('Ir a la pagina Mis empleos', async () => {
            await misEmpleosPage.ir();
            await expect(page).toHaveURL(/empleos/);
        })
    })

    test('Crear empleo', async ({ page }) => {
        const misEmpleosPage = new MisEmpleosPage(page);
        const fotoEmpleo = '../data/image_test.jpeg';
        const nombreUnico = `Empleo #${Date.now()}`;

        await test.step('Ir a crear empleo', async () => {
            await misEmpleosPage.irCrearEmpleo();
            await expect(page).toHaveURL(/crear_empleo/);
        })

        await test.step('Completar el formulario y enviarlo', async () => {
            await misEmpleosPage.crearEmpleo({
                nombre: nombreUnico,
                categoria: '9',
                ubicacion: 'Calle 9 #28-16',
                foto: fotoEmpleo,
                descripcion: 'Necesito a persona para pasear a mi perro por las noches: es un perro pequeño, si estás interesad@ escríbeme'
            })
            await misEmpleosPage.enviarEmpleo();
        })

        await test.step('Verificar que el proceso haya sido exitoso', async () => {
            await expect(page).toHaveURL(/empleos/);
            await expect(page.getByText('Empleo creado exitosamente')).toBeVisible();
            await expect(page.getByText(nombreUnico).first()).toBeVisible();
        })
    })
})