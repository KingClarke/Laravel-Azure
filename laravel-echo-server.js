// Simple startup file for cPanel Node.js app to run Laravel Echo Server
const { spawn } = require('child_process');

const echo = spawn('npx', ['laravel-echo-server', 'start'], {
  stdio: 'inherit',
  shell: true
});

echo.on('close', (code) => {
  console.log(`laravel-echo-server exited with code ${code}`);
});
