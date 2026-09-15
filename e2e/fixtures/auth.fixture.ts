import { test as base } from '@playwright/test';
import { LoginPage } from '../page-objects/LoginPage';

type AuthFixture = {
    loginPage: LoginPage;
};

const testUsuario = { correo: 'test@gmail.com', contraseña: '12345678' };

export const test = base.extend<AuthFixture>({
    loginPage: async ({ page }, use) => {
        const loginPage = new LoginPage(page);
        await loginPage.ir();
        await loginPage.completarDatos(testUsuario);
        await loginPage.enviar();
        await use(loginPage);
    }
})

export { expect } from '@playwright/test';
