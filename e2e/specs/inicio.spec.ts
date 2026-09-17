import { test, expect } from '../fixtures/auth.fixture';
import { InicioPage } from '../page-objects/InicioPage';

test.beforeEach(async ({ loginPage, page }) => {
    const inicioPage = new InicioPage(page);

    await test.step('Ir a la página de inicio', async () => {
        const rol = await inicioPage.obtenerRol();

        if (rol === 'Empleado') {
            await expect(page).toHaveURL(/.*empleado/);
        } else {
            await expect(page).toHaveURL(/.*empleador/);
        }

        await expect(page.getByRole('link', { name: 'Logo SenaWork' })).toBeVisible();
    })
})

test.describe('Tests de la página de inicio', () => {

    test('Cerrar sesión', async ({ page }) => {
        const inicioPage = new InicioPage(page);

        await test.step('Cerrar la sesión', async () => {
            await inicioPage.cerrarSesion();
            await expect(page).toHaveURL(/inicio/);
        })
    })

    // test('Cambiar rol de usuario', async ({ page }) => {
    //     const inicioPage = new InicioPage(page);

    //     await test.step('Dar click en el botón para cambiar de rol', async () => {
    //         await inicioPage.cambiarRol();

    //         const rol = await inicioPage.obtenerRol();

    //         if (rol === 'Empleado') {
    //             await expect(page).toHaveURL(/.*empleado/);
    //         } else {
    //             await expect(page).toHaveURL(/.*empleador/);
    //         }
    //     })
    // })
})
