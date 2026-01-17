import subprocess
import time
from api import get_next_job, mark_printing, mark_done, mark_failed

SUMATRA = r"C:\Users\DELL\AppData\Local\SumatraPDF\SumatraPDF.exe"

print("Print Server Started...")

while True:
    job = get_next_job()
    if not job:
        time.sleep(2)
        continue

    token = job["job_token"]
    file_path = job["file_path"]
    copies = str(job["copies"])

    try:
        print("Printing file:", file_path)
        mark_printing(token)

        subprocess.run([
            SUMATRA,
            "-print-to-default",
            "-silent",
            file_path
        ], check=True)

        mark_done(token)
        print("Print success:", token)

    except Exception as e:
        print("Print failed:", e)
        mark_failed(token)

    time.sleep(1)
