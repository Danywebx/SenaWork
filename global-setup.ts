import { execSync } from 'child_process';
import type { FullConfig } from '@playwright/test';

async function globalSetup(config: FullConfig) {
    const args = process.argv.join(' ');

    const isSingleFromCLI =
        args.includes('.spec.') ||
        args.includes('.test.') ||
        args.includes('-g') ||
        args.includes('--grep') ||
        args.includes('--ui');

    const cliArgs = (config as any)._cliArgs as string[] | undefined;
    const isSingleFromExtension = cliArgs ? cliArgs.length > 0 : false;

    if (isSingleFromCLI || isSingleFromExtension) {
        console.log('\n[Global Setup] Omitiendo migraciones (se detectó prueba individual)...\n');
        return;
    }

    console.log('\nIniciando preparación de la base de datos...');
    try {
        execSync('php artisan migrate:fresh --seed', {
            stdio: 'inherit',
        });

        console.log('Base de datos reiniciada y poblada con éxito.\n');
    } catch (error) {
        console.error('Error ejecutando migrate:fresh --seed:', error);
        throw error;
    }
}

export default globalSetup;

// import { execSync } from 'child_process';

// async function globalSetup() {
//     console.log('\nIniciando preparación de la base de datos...');

//     try {
//         execSync('php artisan migrate:fresh --seed', {
//             stdio: 'inherit',
//         });

//         console.log('Base de datos reiniciada y poblada con éxito.\n');
//     } catch (error) {
//         console.error('Error ejecutando migrate:fresh --seed:', error);
//         throw error;
//     }
// }

// export default globalSetup;
