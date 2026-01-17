import requests

BASE_URL = "http://127.0.0.1:8000"

def get_next_job():
    print("Requesting next job...")
    r = requests.get(f"{BASE_URL}/api/print-jobs/next")
    print("Status:", r.status_code)
    if r.status_code == 200:
        print("Response:", r.text)
        return r.json()
    return None

def mark_printing(token):
    print("Mark printing:", token)
    requests.post(f"{BASE_URL}/api/print-jobs/{token}/printing")

def mark_done(token):
    print("Mark done:", token)
    requests.post(f"{BASE_URL}/api/print-jobs/{token}/done")

def mark_failed(token):
    print("Mark failed:", token)
    requests.post(f"{BASE_URL}/api/print-jobs/{token}/failed")