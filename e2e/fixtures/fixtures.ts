import { test as base } from '@playwright/test';
import { LoginPage } from '../page-objects/LoginPage';
import { RegisterPage } from '../page-objects/RegisterPage';
import { ProfilePage } from '../page-objects/ProfilePage';

type MisFixtures = {
    loguearUsuario: LoginPage;
    loguearUsuarioEmpleador: LoginPage;
    registrarUsuario: RegisterPage;
    registrarUsuarioEmpleador: RegisterPage;
    completarPerfil: ProfilePage;    
};

export const test = base.extend<MisFixtures>({
    loguearUsuario: async ({ page }, use) => {
        const loginPage = new LoginPage(page);
        const testUsuario = { correo: 'test@gmail.com', contraseña: '12345678' };

        await loginPage.ir();
        await loginPage.completarDatos(testUsuario);
        await loginPage.enviar();
        await use(loginPage);
    },

    loguearUsuarioEmpleador: async ({ page }, use) => {
        const loginPage = new LoginPage(page);
        const testUsuario = { correo: 'test_empleador@gmail.com', contraseña: '12345678' };

        await loginPage.ir();
        await loginPage.completarDatos(testUsuario);
        await loginPage.enviar();
        await use(loginPage);
    },

    registrarUsuario: async ({ page }, use) => {
        const registerPage = new RegisterPage(page);
        const min = 1e9;
        const max = 9e9;
        const numRandom = (Math.floor(Math.random() * (max - min + 1)) + min).toString();
        const emailUnico = `test_${Date.now()}@gmail.com`;

        await registerPage.ir();
        await registerPage.completarDatos({
            nombres: 'Test',
            apellidos: 'User User',
            tipoDocumento: 'Cédula de ciudadanía',
            numeroDocumento: numRandom,
            fechaNacimiento: '2000-10-26',
            celular: '3001234567',
            direccion: 'Calle sola #15-56',
            correo: emailUnico,
            contraseña: '12345678',
            categoria: '9',
            rol: 'Empleado'
        });
        await registerPage.aceptarTerms();
        await registerPage.enviar();
        await use(registerPage);
    },

    registrarUsuarioEmpleador: async ({ page }, use) => {
        const registerPage = new RegisterPage(page);
        const min = 1e9;
        const max = 9e9;
        const numRandom = (Math.floor(Math.random() * (max - min + 1)) + min).toString();
        const emailUnico = `test_${Date.now()}@gmail.com`;

        await registerPage.ir();
        await registerPage.completarDatos({
            nombres: 'Test',
            apellidos: 'User User',
            tipoDocumento: 'Cédula de ciudadanía',
            numeroDocumento: numRandom,
            fechaNacimiento: '2000-10-26',
            celular: '3001234567',
            direccion: 'Calle sola #15-56',
            correo: emailUnico,
            contraseña: '12345678',
            categoria: '9',
            rol: 'Empleador'
        });
        await registerPage.aceptarTerms();
        await registerPage.enviar();
        await use(registerPage);
    },

    completarPerfil: async ({ page }, use) => {
        const profilePage = new ProfilePage(page);

        await profilePage.ir();
        await profilePage.completarPerfil()
        await profilePage.enviar();
        await use(profilePage);
    }
})

export { expect } from '@playwright/test';
