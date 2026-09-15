import { test, expect } from '@playwright/test';
import { LoginPage } from '../page-objects/LoginPage';

test.beforeEach(async ({ page }) => {
    await test.step('Ir a la página de login', async () => {
        const loginPage = new LoginPage(page);
        await loginPage.ir();
    });
});

test.describe('Loguear usuario', () => {
    test('Loguear usuario exitosamente', async ({ page }) => {
        const loginPage = new LoginPage(page);

        await test.step('Rellenar formulario', async () => {
            await loginPage.completarDatos({ correo: 'test@gmail.com', contraseña: '12345678' });
        });

        await test.step('Enviar formulario (petición POST)', async () => {
            await loginPage.enviar();
            await expect(page).toHaveURL(/empleado/);
        })
    });

    test('Loguear usuario con credenciales incorrectas', async ({ page }) => {
        const loginPage = new LoginPage(page);

        await test.step('Rellenar formulario con datos incorrectos', async () => {
            await loginPage.completarDatos({ correo: 'test_error@gmail.com', contraseña: 'error12345678' });
        });

        await test.step('Enviar formulario (petición POST) con error', async () => {
            await loginPage.enviar();
            await expect(page.getByText('Credenciales incorrectas.')).toBeVisible();
        })
    });

});