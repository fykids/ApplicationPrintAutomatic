import subprocess

def print_pdf(file_path, copies):
    for _ in range(copies):
        subprocess.run([
            file_path
        ])
