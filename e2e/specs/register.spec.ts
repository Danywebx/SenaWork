import { test, expect } from '@playwright/test';
import { RegisterPage } from '../page-objects/RegisterPage';

test.beforeEach(async ({ page }) => {
    await test.step('Ir a la página de registro', async () => {
        const registerPage = new RegisterPage(page);
        await registerPage.ir();
    })
})

test.describe('Registro de usuario', () => {
    test('Registrar usuario exitosamente', async ({ page }) => {
        const registerPage = new RegisterPage(page);
        const min = 1e9;
        const max = 9e9;
        const numRandom = (Math.floor(Math.random() * (max - min + 1)) + min).toString();
        const emailUnico = `test_${Date.now()}@gmail.com`;

        await test.step('Rellenar formulario', async () => {
            await registerPage.completarDatos({
                nombres: 'John Pepito',
                apellidos: 'Doe Pérez',
                tipoDocumento: 'Cédula de ciudadanía',
                numeroDocumento: numRandom,
                fechaNacimiento: '2000-10-26',
                celular: '3008467985',
                direccion: 'Calle sola #15-56',
                correo: emailUnico,
                contraseña: '12345678',
                categoria: '9',
                rol: 'Empleado'
            });
        });

        await test.step('Aceptar términos y petición post de crear cuenta', async () => {
            await registerPage.aceptarTerms();
            await expect(page.getByRole('checkbox', { name: 'Acepto los términos y' })).toBeChecked();

            await registerPage.enviar();
            await expect(page).toHaveURL(/empleado/);
        });
    });

    test('Registrar usuario con correo existente', async ({ page }) => {
        const registerPage = new RegisterPage(page);
        const min = 1e9;
        const max = 9e9;
        const numRandom = (Math.floor(Math.random() * (max - min + 1)) + min).toString();

        await test.step('Rellenar formulario con correo existente', async () => {
            await registerPage.completarDatos({
                nombres: 'John Pepito',
                apellidos: 'Doe Pérez',
                tipoDocumento: 'Cédula de ciudadanía',
                numeroDocumento: numRandom,
                fechaNacimiento: '2000-10-26',
                celular: '3008467985',
                direccion: 'Calle sola #15-56',
                correo: 'test@gmail.com',
                contraseña: '12345678',
                categoria: '9',
                rol: 'Empleado'
            });
        });

        await test.step('Aceptar términos, petición post de crear cuenta y mensaje de error', async () => {
            await registerPage.aceptarTerms();
            await expect(page.getByRole('checkbox', { name: 'Acepto los términos y' })).toBeChecked();

            await registerPage.enviar();
            await expect(page.locator('.alert')).toHaveText('The email has already been taken.');
        });
    })

    test('Registrar usuario con número de documento existente', async ({ page }) => {
        const registerPage = new RegisterPage(page);
        const emailUnico = `test_${Date.now()}@gmail.com`;

        await test.step('Rellenar formulario con número de documento existente', async () => {
            await registerPage.completarDatos({
                nombres: 'John Pepito',
                apellidos: 'Doe Pérez',
                tipoDocumento: 'Cédula de ciudadanía',
                numeroDocumento: '1234567890',
                fechaNacimiento: '2000-10-26',
                celular: '3008467985',
                direccion: 'Calle sola #15-56',
                correo: emailUnico,
                contraseña: '12345678',
                categoria: '9',
                rol: 'Empleado'
            });
        });

        await test.step('Aceptar términos, petición post de crear cuenta y mensaje de error', async () => {
            await registerPage.aceptarTerms();
            await expect(page.getByRole('checkbox', { name: 'Acepto los términos y' })).toBeChecked();

            await registerPage.enviar();
            await expect(page.locator('.alert')).toHaveText('The numero documento has already been taken.');
        });
    })
});
