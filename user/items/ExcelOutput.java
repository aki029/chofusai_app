import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;

import org.apache.poi.ss.usermodel.Cell;
import org.apache.poi.ss.usermodel.Row;
import org.apache.poi.ss.usermodel.Sheet;
import org.apache.poi.ss.usermodel.Workbook;
import org.apache.poi.ss.usermodel.WorkbookFactory;

public class ExcelOutput{
    public static void main(String[] args) {
        Workbook workbook = WorkbookFactory.create(new File("../template/bank_bill.xlsx"));
        Sheet sheet = workbook.getSheet("Sheet1");
    }
}