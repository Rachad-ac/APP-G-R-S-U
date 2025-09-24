import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import { environment } from "../../../environments/environment";
import { Observable, tap } from 'rxjs';


@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private apiUrl = `${environment.baseUrl}`;

  constructor(private http: HttpClient, private router: Router) {}

  register(user:any) : Observable<any> {
    return this.http.post<any>(`${environment.baseUrl}register`, user)
      .pipe(tap((res: any) => {
      localStorage.setItem('token', res.token);
      localStorage.setItem('role', res.role);
    }));
  }

  login(user: any) : Observable<any> {
    return this.http.post(`${this.apiUrl}login`, user);
  }

  logout( user : any) :  Observable<any> {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    this.router.navigate(['/login']);
    return this.http.post<any>(`${environment.baseUrl}logout` , user);
  }

  saveToken(token: string) {
    localStorage.setItem('token', token);
  }

  getToken(): string | null {
    return localStorage.getItem('token');
  }

  saveUser(user: any) {
    localStorage.setItem('user', JSON.stringify(user));
  }

  getUser(): any {
    const user = localStorage.getItem('user');
    return user ? JSON.parse(user) : null;
  }

  isAuthenticated(): boolean {
    return !!this.getToken();
  }

  hasRole(role: string): boolean {
    const user = this.getUser();
    return user && user.role === role;
  }
}
