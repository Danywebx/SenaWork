import { test, expect } from '../fixtures/fixtures';
import { ProfilePage } from '../page-objects/ProfilePage';

test.describe('Tests de la página perfil con usuario estándar', () => {

    test.beforeEach(async ({ registrarUsuario, page }) => {
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

    test('Actualizar perfil', async ({ page }) => {
        const profilePage = new ProfilePage(page);
        const fotoPerfil = '../data/image_test.jpeg';
        const rutaPortafolio = '../data/Prueba_Documento_de_Portafolio.pdf';

        await test.step('Actualizar datos', async () => {
            await profilePage.editarPerfil({
                foto: fotoPerfil,
                telefono: '3125259487',
                portafolio: rutaPortafolio,
                categoria: '4',
            });
        })

        await test.step('Verificar que el proceso haya sido exitoso', async () => {
            await expect(page.getByText('Perfil actualizado con éxito.')).toBeVisible();

            const navProfileImg = page.locator('header .nav-profile img');
            const cardProfileImg = page.locator('.profile-card img');
            await expect(navProfileImg).toBeVisible();
            await expect(cardProfileImg).toBeVisible();

            const isNavImgLoaded = await navProfileImg.evaluate(
                (img) => (img as HTMLImageElement).complete && (img as HTMLImageElement).naturalWidth > 0
            );
            const isCardImgLoaded = await cardProfileImg.evaluate(
                (img) => (img as HTMLImageElement).complete && (img as HTMLImageElement).naturalWidth > 0
            );

            expect(isNavImgLoaded).toBeTruthy();
            expect(isCardImgLoaded).toBeTruthy();
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
