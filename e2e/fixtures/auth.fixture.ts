import { test as base } from '@playwright/test';
import { LoginPage } from '../page-objects/LoginPage';

type AuthFixture = {
    loginPage: LoginPage;
    loginPageEliminar: LoginPage;    
    loginPageContrasenas: LoginPage;    
};

const testUsuario = { correo: 'test@gmail.com', contraseña: '12345678' };
const testUsuarioEliminar = { correo: 'test_user_delete@gmail.com', contraseña: '12345678' };
const testUsuarioContrasenas = { correo: 'test_user_contrasenas@gmail.com', contraseña: '12345678' };

export const test = base.extend<AuthFixture>({
    loginPage: async ({ page }, use) => {
        const loginPage = new LoginPage(page);
        await loginPage.ir();
        await loginPage.completarDatos(testUsuario);
        await loginPage.enviar();
        await use(loginPage);
    },

    loginPageEliminar: async ({ page }, use) => {
        const loginPage = new LoginPage(page);
        await loginPage.ir();
        await loginPage.completarDatos(testUsuarioEliminar);
        await loginPage.enviar();
        await use(loginPage);
    },

    loginPageContrasenas: async ({ page }, use) => {
        const loginPage = new LoginPage(page);
        await loginPage.ir();
        await loginPage.completarDatos(testUsuarioContrasenas);
        await loginPage.enviar();
        await use(loginPage);
    }
})

export { expect } from '@playwright/test';
