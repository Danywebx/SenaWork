import { test, expect } from '../fixtures/auth.fixture';
import { ProfilePage } from '../page-objects/ProfilePage';

test.describe('Tests de la página perfil con usuario estándar', () => {

    test.beforeEach(async ({ loginPage, page }) => {
        const profilePage = new ProfilePage(page);

        await test.step('Ir a la página del perfil', async () => {
            await expect(page).toHaveURL(/empleado/)
            await profilePage.ir();
            await expect(page).toHaveURL(/perfil/);
        })
    })

    test('Completar perfil', async ({ page }) => {
        const profilePage = new ProfilePage(page);

        await test.step('Completar perfil y enviar formulario', async () => {
            await profilePage.completarPerfil();
            await profilePage.enviar();
        })

        await test.step('Verificar que el proceso haya sido exitoso', async () => {
            await expect(page.getByText('Documentos subidos')).toBeVisible();
            await expect(page.getByRole('button', { name: 'Completar perfil' })).not.toBeVisible();
        })
    })
})

test.describe('Cambiar contraseñas con usuario definido para estos tests', () => {

    test.beforeEach(async ({ loginPageContrasenas, page }) => {
        const profilePage = new ProfilePage(page);

        await test.step('Ir a la página del perfil', async () => {
            await expect(page).toHaveURL(/empleado/)
            await profilePage.ir();
            await expect(page).toHaveURL(/perfil/);
        })
    })

    test('Cambiar contraseña con contraseña actual errónea', async ({ page }) => {
        const profilePage = new ProfilePage(page);

        await test.step('Cambiar contraseña con dato erróneo', async () => {
            await profilePage.cambiarContrasena({ claveAntigua: 'error12345678', claveNueva: '123456789' });
        })

        await test.step('Verificar que se muestre el mensaje de error', async () => {
            await expect(page).toHaveURL(/perfil/);
            await expect(page.getByText('La contraseña actual es incorrecta')).toBeVisible();
        })
    })

    test('Cambiar contraseña exitosamente', async ({ page }) => {
        const profilePage = new ProfilePage(page);

        await test.step('Cambiar contraseña', async () => {
            await profilePage.cambiarContrasena({ claveAntigua: '12345678', claveNueva: '123456789' });
        })

        await test.step('Verificar que el proceso haya sido exitoso', async () => {
            await expect(page).toHaveURL(/inicio/);
            await expect(page.getByText('Iniciar sesión Registrarse')).toBeVisible();
        })
    })
})

test.describe('Eliminar cuenta con usuario definido para este test', () => {

    test('Eliminar cuenta', async ({ loginPageEliminar, page }) => {
        const profilePage = new ProfilePage(page);

        await test.step('Ir a la página del perfil', async () => {
            await expect(page).toHaveURL(/empleado/)
            await profilePage.ir();
            await expect(page).toHaveURL(/perfil/);
        })

        await test.step('Eliminar cuenta', async () => {
            await profilePage.eliminarCuenta();
        })

        await test.step('Verificar que el proceso haya sido exitoso', async () => {
            await expect(page).toHaveURL(/inicio/);
            await expect(page.getByText('Iniciar sesión Registrarse')).toBeVisible();
        })
    })
})
