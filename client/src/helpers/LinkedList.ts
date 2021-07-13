export default class LinkedList<T> {
    private root : Node<T>;
    private last : Node<T>;
    private current : Node<T>;
    private _size : number;
    constructor(items : T[] = []) {
        this._size = items.length;
        this.root = new Node(items[0]);
        this.last = this.root;
        this.current = this.root;
        for(let i = 1; i < items.length; i++) {
            let next = new Node(items[i]);
            this.current.next = next;
            this.current = next;
            this.last = this.current;
        }

        this.current.next = this.root;
        this.current = this.root;
    }

    public next() {
        let val = this.current.value;
        this.current = this.current.next;
        return val;
    }

    public reset() {
        this.current = this.root;
    }

    public size() {
        return this._size;
    }

    public push(o : T) {
        const newNode = new Node(o);
        newNode.next = this.root;
        this.last.next = newNode;
        this.last = newNode;
        this._size++;
    }
}

class Node<T> {
    public value : T;
    public next : Node<T>
    constructor(value: T) {
        this.value = value;
        this.next = this;
    }
}