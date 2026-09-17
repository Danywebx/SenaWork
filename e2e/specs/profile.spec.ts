import { test, expect } from '../fixtures/auth.fixture';
import { ProfilePage } from '../page-objects/ProfilePage';

test.beforeEach(async ({ loginPage, page }) => {
    const profilePage = new ProfilePage(page);

    await test.step('Ir a la página del perfil', async () => {
        await expect(page).toHaveURL(/empleado/)
        await profilePage.ir();
        await expect(page).toHaveURL(/perfil/);
    })
})

test.describe('Tests de la página perfil', () => {

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

    test('Eliminar cuenta', async ({ page }) => {
        const profilePage = new ProfilePage(page);

        await test.step('Eliminar cuenta', async () => {
            await profilePage.eliminarCuenta();
        })

        await test.step('Verificar que el proceso haya sido exitoso', async () => {
            await expect(page).toHaveURL(/inicio/);
            await expect(page.getByText('Iniciar sesión Registrarse')).toBeVisible();
        })
    })
})
