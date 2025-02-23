```mermaid
stateDiagram
    [*] --> Idle

    Idle --> WaitingForSelection : Insert Coin
    WaitingForSelection --> Dispensing : Select Valid Product
    WaitingForSelection --> WaitingForSelection : Error (No Stock / Insufficient Balance)

    Dispensing --> Idle : Product Dispensed
```
