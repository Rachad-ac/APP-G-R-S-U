import { HttpClient, HttpParams } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class TestService {

  constructor(protected http: HttpClient) {}
 
      createTest(test: any): Observable<any> {
        return this.http.post<any>(`${environment.baseUrl}tests`, test);
      }
 
      updateTest(testId: any, test: any): Observable<any> {
        return this.http.put<any>(`${environment.baseUrl}tests/${testId}`, test);
      }

      getTestById(testId: any): Observable<any> {
        return this.http.get<any>(`${environment.baseUrl}tests/${testId}`);
      }

    getAllTests(req?: any): Observable<any> {
     let params: HttpParams = new HttpParams();
   
     if (req) {
       if (req.type) {
         params = params.append("type", req.type);
       }
       if (req.date) {
         params = params.append("date", req.date);
       }
       if (req.bareme) {
         params = params.append("bareme", req.bareme);
       }
       if(req?.formation != undefined && req?.formation){
         params = params.append("formation", req?.formation);
       }
        if (req.formationId != undefined && req?.formationId) {
      params = params.append("formationId", req.formationId);
    }
             
       params = params.append("page", req.page ?? 0);
       params = params.append("size", req.size ?? 10);
     } else {
       params = params.append("page", 0);
       params = params.append("size", 100000);
     }
 
     return this.http.get<any>(`${environment.baseUrl}tests/all`, { params });
   }


      deleteTest(testId: any): Observable<any> {
        return this.http.delete<any>(`${environment.baseUrl}tests/${testId}`, {
          observe: 'response'
        });
      }
}
