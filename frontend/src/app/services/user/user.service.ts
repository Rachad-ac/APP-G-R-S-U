import { Injectable } from '@angular/core';
import { HttpClient, HttpParams } from "@angular/common/http";
import { Observable, tap } from "rxjs";
import { environment } from "../../../environments/environment";

@Injectable({
  providedIn: 'root'
})
export class UserService {

  constructor(protected http: HttpClient) { }

  register(user:any) : Observable<any> {
    return this.http.post<any>(`${environment.baseUrl}register`, user)
      .pipe(tap((res: any) => {
      localStorage.setItem('token', res.token);
      localStorage.setItem('role', res.role);
    }));
  }

  login(user:any) : Observable<any> {
    return this.http.post<any>(`${environment.baseUrl}login`, user);
  }

  logout(user : any) : void {
    this.http.post<any>(`${environment.baseUrl}logout` , user);
    localStorage.clear();
  }

  getToken(): string | null {
    return localStorage.getItem('token');
  }

  getRole(): string | null {
    return localStorage.getItem('role');
  }
}
