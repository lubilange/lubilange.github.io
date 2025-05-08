from flask import Flask, request, jsonify
from flask_cors import CORS
import mysql.connector

app = Flask(__name__)
CORS(app)

# Connexion à la base de données MySQL
db = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",  # Remplacez par votre mot de passe MySQL
    database="school_registration"
)
cursor = db.cursor(dictionary=True)

# 🔹 Route pour enregistrer une école
@app.route("/register-school", methods=["POST"])
def register_school():
    data = request.json
    sql = """INSERT INTO schools (name, address, description, devise1, devise2, devise3, section, email, phoneNumber, siteweb, pupilCount, teacherCount, gradCount, fees) 
             VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"""
    values = (
        data["name"], data["address"], data["description"], data["devise1"], data["devise2"], data["devise3"], 
        data["section"], data["email"], data["phoneNumber"], data["siteweb"], 
        data["pupilCount"], data["teacherCount"], data["gradCount"], data["fees"]
    )

    cursor.execute(sql, values)
    db.commit()
    return jsonify({"message": "École enregistrée avec succès"}), 201

# 🔹 Route pour enregistrer un étudiant
@app.route("/register-student", methods=["POST"])
def register_student():
    data = request.json
    sql = """INSERT INTO students (firstName, lastName, birthdate, nationality, email, phoneNumber, address, sexe, school_id) 
             VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)"""
    values = (
        data["firstName"], data["lastName"], data["birthdate"], data["nationality"], 
        data["email"], data["phoneNumber"], data["address"], data["sexe"], data["school_id"]
    )

    cursor.execute(sql, values)
    db.commit()
    return jsonify({"message": "Élève enregistré avec succès"}), 201

# 🔹 Route pour récupérer les écoles
@app.route("/schools", methods=["GET"])
def get_schools():
    cursor.execute("SELECT * FROM schools")
    schools = cursor.fetchall()
    return jsonify(schools)

# 🔹 Route pour récupérer les élèves
@app.route("/students", methods=["GET"])
def get_students():
    cursor.execute("SELECT * FROM students")
    students = cursor.fetchall()
    return jsonify(students)

if __name__ == "__main__":
    app.run(debug=True)
